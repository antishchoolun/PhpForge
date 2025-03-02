<?php

namespace App\Services\DomainValuation;

use App\Services\GroqApi\GroqApiClient;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class DomainValuationService
{
    protected $groqApi;
    
    // Domain valuation constants
    const MIN_DOMAIN_LENGTH = 3;
    const MAX_DOMAIN_LENGTH = 63;
    const TLD_LIST = ['com', 'net', 'org', 'io', 'ai', 'app', 'dev', 'tech'];

    public function __construct(GroqApiClient $groqApi)
    {
        $this->groqApi = $groqApi;
    }

    public function analyzeDomain(string $domain, array $factors = [], string $category = 'general', string $currency = 'USD')
    {
        try {
            // Basic domain validation
            if (!$this->validateDomain($domain)) {
                throw new \InvalidArgumentException('Invalid domain name format');
            }

            // Build analysis prompt with selected factors
            $prompt = $this->buildValuationPrompt($domain, $factors, $category);
            
            // Get AI analysis
            $result = $this->groqApi->valuateDomain($prompt);
            
            // Parse and format the valuation
            $valuation = $this->parseValuationResponse($result['analysis']);
            
            // Enrich valuation with additional data
            $enrichedValuation = $this->enrichValuationData($valuation, $domain, $currency);
            
            // Calculate summary metrics
            $summary = $this->calculateValuationSummary($enrichedValuation);
            
            return [
                'success' => true,
                'valuation' => $enrichedValuation,
                'summary' => $summary
            ];

        } catch (\Exception $e) {
            Log::error('Domain valuation error: ' . $e->getMessage(), [
                'domain' => $domain,
                'factors' => $factors,
                'category' => $category
            ]);

            return [
                'success' => false,
                'message' => 'Failed to analyze domain: ' . $e->getMessage()
            ];
        }
    }

    protected function validateDomain(string $domain): bool
    {
        // Remove any protocol or www prefix
        $domain = preg_replace('#^https?://|www\.#', '', strtolower($domain));
        
        // Basic domain validation
        if (strlen($domain) < self::MIN_DOMAIN_LENGTH || strlen($domain) > self::MAX_DOMAIN_LENGTH) {
            return false;
        }

        // Advanced domain validation using DNS records (optional)
        // return checkdnsrr($domain, 'A') || checkdnsrr($domain, 'AAAA');
        
        return (bool) preg_match('/^([a-z0-9][a-z0-9-]*[a-z0-9]\.)+[a-z]{2,}$/', $domain);
    }

    protected function buildValuationPrompt(string $domain, array $factors, string $category): string
    {
        $prompt = "Analyze the following domain name for valuation:\n\n";
        $prompt .= "Domain: $domain\n";
        $prompt .= "Category: $category\n\n";
        
        if (!empty($factors)) {
            $prompt .= "Consider these specific factors:\n";
            foreach ($factors as $factor) {
                switch ($factor) {
                    case 'market_trends':
                        $prompt .= "- Current market trends and future potential\n";
                        break;
                    case 'seo_metrics':
                        $prompt .= "- SEO value, brandability, and traffic potential\n";
                        break;
                    case 'brand_potential':
                        $prompt .= "- Brand strength and memorability\n";
                        break;
                    case 'industry_relevance':
                        $prompt .= "- Industry relevance and market fit\n";
                        break;
                    case 'length_analysis':
                        $prompt .= "- Domain length and composition analysis\n";
                        break;
                    case 'keyword_value':
                        $prompt .= "- Keyword commercial value\n";
                        break;
                    case 'sales_history':
                        $prompt .= "- Similar domain sales history\n";
                        break;
                    case 'extensions':
                        $prompt .= "- Available TLD variations\n";
                        break;
                    case 'trademark_check':
                        $prompt .= "- Trademark considerations\n";
                        break;
                    case 'commerce_potential':
                        $prompt .= "- E-commerce and business potential\n";
                        break;
                }
            }
        }

        $prompt .= "\nProvide the analysis in this JSON format:\n";
        $prompt .= "{\n";
        $prompt .= "  \"estimatedValue\": number,\n";
        $prompt .= "  \"currency\": \"USD\",\n";
        $prompt .= "  \"summary\": \"Overall valuation summary\",\n";
        $prompt .= "  \"factors\": [\n";
        $prompt .= "    {\n";
        $prompt .= "      \"name\": \"Factor name\",\n";
        $prompt .= "      \"score\": number (0-10),\n";
        $prompt .= "      \"analysis\": \"Detailed analysis\",\n";
        $prompt .= "      \"suggestion\": \"Optional suggestion\",\n";
        $prompt .= "      \"data\": { optional metrics }\n";
        $prompt .= "    }\n";
        $prompt .= "  ]\n";
        $prompt .= "}\n\n";
        $prompt .= "Return ONLY the JSON object, no additional text.";

        return $prompt;
    }

    protected function parseValuationResponse(string $response): array
    {
        // Extract JSON from response
        if (preg_match('/\{[\s\S]*\}/', $response, $matches)) {
            $jsonStr = $matches[0];
            $valuation = json_decode($jsonStr, true);
            
            if (json_last_error() === JSON_ERROR_NONE && is_array($valuation)) {
                return $valuation;
            }
        }
        
        throw new \RuntimeException('Failed to parse valuation response');
    }

    protected function enrichValuationData(array $valuation, string $domain, string $currency): array
    {
        // Convert currency if needed
        if ($currency !== ($valuation['currency'] ?? 'USD')) {
            $valuation['estimatedValue'] = $this->convertCurrency(
                $valuation['estimatedValue'],
                $valuation['currency'] ?? 'USD',
                $currency
            );
            $valuation['currency'] = $currency;
        }

        // Add TLD availability data
        $valuation['tldAvailability'] = $this->checkTldAvailability($domain);

        // Try to get WHOIS data, but continue without it if not available
        $whoisData = $this->tryGetWhoisData($domain);
        if ($whoisData !== null) {
            $valuation['whoisData'] = $whoisData;
        }

        return $valuation;
    }

    protected function convertCurrency(float $amount, string $from, string $to): float
    {
        if ($from === $to) return $amount;

        try {
            $response = Http::get("https://api.exchangerate-api.com/v4/latest/{$from}");
            if ($response->successful()) {
                $rates = $response->json()['rates'];
                return $amount * ($rates[$to] ?? 1);
            }
        } catch (\Exception $e) {
            Log::warning('Currency conversion failed: ' . $e->getMessage());
        }

        return $amount;
    }

    protected function checkTldAvailability(string $domain): array
    {
        $domainParts = explode('.', $domain);
        $name = $domainParts[0];
        $availability = [];

        foreach (self::TLD_LIST as $tld) {
            try {
                $available = !checkdnsrr("{$name}.{$tld}", 'ANY');
                $availability[$tld] = $available;
            } catch (\Exception $e) {
                $availability[$tld] = null;
            }
        }

        return $availability;
    }

    protected function tryGetWhoisData(string $domain): ?array
    {
        try {
            // Check if whois command exists
            $whoisCheck = shell_exec('where whois 2>&1');
            if (empty($whoisCheck) || str_contains($whoisCheck, 'not recognized')) {
                return null;
            }

            $whois = shell_exec("whois " . escapeshellarg($domain));
            if (empty($whois)) {
                return null;
            }

            $data = [
                'registrar' => $this->extractWhoisField($whois, 'Registrar'),
                'created' => $this->extractWhoisField($whois, 'Creation Date'),
                'expires' => $this->extractWhoisField($whois, 'Registry Expiry Date'),
                'updated' => $this->extractWhoisField($whois, 'Updated Date')
            ];

            // Only return if we got at least one piece of data
            return array_filter($data) ? $data : null;

        } catch (\Exception $e) {
            Log::info('WHOIS lookup not available: ' . $e->getMessage());
            return null;
        }
    }

    protected function extractWhoisField(string $whois, string $field): ?string
    {
        if (preg_match("/$field: (.+)/i", $whois, $matches)) {
            return trim($matches[1]);
        }
        return null;
    }

    protected function calculateValuationSummary(array $valuation): array
    {
        $summary = [
            'estimatedValue' => $this->formatCurrencyValue($valuation['estimatedValue'], $valuation['currency']),
            'marketDemand' => 0,
            'developmentPotential' => 0,
            'brandScore' => 0
        ];

        // Calculate averages from factor scores
        if (!empty($valuation['factors'])) {
            $marketFactors = ['market_trends', 'industry_relevance', 'sales_history'];
            $devFactors = ['seo_metrics', 'commerce_potential', 'extensions'];
            $brandFactors = ['brand_potential', 'length_analysis', 'keyword_value'];

            foreach ($valuation['factors'] as $factor) {
                $name = strtolower(str_replace(' ', '_', $factor['name']));
                if (in_array($name, $marketFactors)) {
                    $summary['marketDemand'] += $factor['score'];
                }
                if (in_array($name, $devFactors)) {
                    $summary['developmentPotential'] += $factor['score'];
                }
                if (in_array($name, $brandFactors)) {
                    $summary['brandScore'] += $factor['score'];
                }
            }

            // Average the scores
            $summary['marketDemand'] = round($summary['marketDemand'] / count($marketFactors));
            $summary['developmentPotential'] = round($summary['developmentPotential'] / count($devFactors));
            $summary['brandScore'] = round($summary['brandScore'] / count($brandFactors));
        }

        return $summary;
    }

    protected function formatCurrencyValue(float $value, string $currency): string
    {
        return number_format($value, 0, '.', ',');
    }
}
