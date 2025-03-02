/**
 * Domain Valuation functionality
 */
import { showError } from './errorHandler';

export function initDomainValuation() {
    const form = document.getElementById('domain-valuation-form');
    const analyzeBtn = document.getElementById('analyze-domain-btn');
    const valuationResult = document.getElementById('valuation-result');
    const mainContent = document.querySelector('.modal-content > .h-full > div:nth-child(2)');
    
    if (!form || !analyzeBtn) return;

    // Handle form submission
    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        e.stopPropagation(); // Ensure no other handlers interfere
        
        // Get form data
        const formData = new FormData(form);
        const domain = formData.get('domain') || '';
        const category = formData.get('category') || 'general';
        const currency = formData.get('currency') || 'USD';
        const factors = Array.from(form.querySelectorAll('input[name="factors[]"]:checked'))
            .map(checkbox => checkbox.value);

        // Client-side domain validation
        if (!validateDomain(domain)) {
            showError({
                message: 'Please enter a valid domain name'
            });
            return;
        }

        if (factors.length === 0) {
            showError({
                message: 'Please select at least one valuation factor'
            });
            return;
        }

        // Log data being sent (for debugging)
        console.log('Submitting domain valuation request:', {
            domain,
            category,
            currency,
            factors
        });
        
        // Show quantum loader
        window.dispatchEvent(new CustomEvent('analyzing-domain'));
        
        // Show loading state
        const originalBtnText = analyzeBtn.innerHTML;
        analyzeBtn.innerHTML = '<span class="spinner"></span> Analyzing...';
        analyzeBtn.disabled = true;
        
        try {
            // Make API request
            const response = await fetch('/tools/domain-valuation', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    domain,
                    category,
                    currency,
                    factors
                })
            });

            const result = await response.json();

            // Handle error responses
            if (!result.success) {
                showError(result);
                return;
            }

            // Artificial delay for the quantum animation (minimum 2 seconds)
            await new Promise(resolve => setTimeout(resolve, 2000));

            // Format the results
            const reportContent = formatValuationResults(result.valuation);
            const contentElement = document.getElementById('valuation-report');
            if (contentElement) {
                contentElement.innerHTML = reportContent;
            }

            // Update summary metrics
            updateValuationSummary(result.summary);

            // Show the result container with animation
            if (valuationResult) {
                valuationResult.classList.add('animate__animated', 'animate__fadeInRight');
                valuationResult.classList.remove('hidden');
                mainContent.classList.remove('grid-cols-1');
                mainContent.classList.add('flex', 'flex-row');

                // Remove animation classes after animation completes
                valuationResult.addEventListener('animationend', () => {
                    valuationResult.classList.remove('animate__animated', 'animate__fadeInRight');
                }, { once: true });
            }

            showNotification('Domain valuation completed!', 'success');

        } catch (error) {
            showError({
                message: error.message || 'An unexpected error occurred during domain valuation'
            });
        } finally {
            // Hide quantum loader
            window.dispatchEvent(new CustomEvent('analysis-complete'));
            
            // Reset button state
            analyzeBtn.innerHTML = originalBtnText;
            analyzeBtn.disabled = false;
        }
    });
}

// Validate domain name format
function validateDomain(domain) {
    const domainRegex = /^([a-zA-Z0-9][a-zA-Z0-9-]*[a-zA-Z0-9]\.)+[a-zA-Z]{2,}$/;
    return domainRegex.test(domain);
}

// Format valuation results into HTML
function formatValuationResults(valuation) {
    if (!valuation || !Array.isArray(valuation.factors)) return '';

    // Format currency value
    const formattedValue = new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: valuation.currency || 'USD',
        maximumFractionDigits: 0
    }).format(valuation.estimatedValue);

    // Create HTML content
    let html = `
        <div class="mb-8">
            <div class="bg-white dark:bg-gray-900 rounded-lg p-6 shadow-sm">
                <h3 class="text-2xl font-bold text-purple-600 dark:text-purple-400 mb-2">
                    ${formattedValue}
                </h3>
                <p class="text-gray-600 dark:text-gray-400">
                    ${valuation.summary}
                </p>
            </div>
        </div>
    `;

    // Add factor analysis sections
    html += valuation.factors.map(factor => `
        <div class="factor-item border-l-4 rounded-lg p-4 mb-4 ${getFactorStyles(factor)}">
            <div class="flex items-start gap-3">
                <div class="flex-1 space-y-1">
                    <div class="flex items-center gap-2">
                        <span class="px-2 py-1 text-xs font-medium rounded-full ${getFactorScoreClass(factor.score)} bg-white/50 dark:bg-black/20">
                            Score: ${factor.score}/10
                        </span>
                        <h4 class="font-medium text-gray-900 dark:text-white">
                            ${factor.name}
                        </h4>
                    </div>
                    <p class="text-gray-600 dark:text-gray-300">
                        ${factor.analysis}
                    </p>
                    ${factor.suggestion ? `
                        <div class="mt-2 p-3 bg-white dark:bg-gray-800 rounded">
                            <span class="font-medium text-gray-900 dark:text-white">Suggestion:</span>
                            <p class="mt-1 text-gray-700 dark:text-gray-300">${factor.suggestion}</p>
                        </div>
                    ` : ''}
                    ${factor.data ? `
                        <div class="mt-2 text-sm space-y-1">
                            ${Object.entries(factor.data).map(([key, value]) => `
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">${key}:</span>
                                    <span class="font-medium text-gray-900 dark:text-white">${value}</span>
                                </div>
                            `).join('')}
                        </div>
                    ` : ''}
                </div>
            </div>
        </div>
    `).join('');

    return html;
}

// Get styling classes based on factor score
function getFactorStyles(factor) {
    const score = factor.score;
    if (score >= 8) return 'border-green-500 bg-green-50 dark:bg-green-900/20';
    if (score >= 6) return 'border-blue-500 bg-blue-50 dark:bg-blue-900/20';
    if (score >= 4) return 'border-yellow-500 bg-yellow-50 dark:bg-yellow-900/20';
    return 'border-red-500 bg-red-50 dark:bg-red-900/20';
}

// Get score indicator classes
function getFactorScoreClass(score) {
    if (score >= 8) return 'text-green-700 dark:text-green-300';
    if (score >= 6) return 'text-blue-700 dark:text-blue-300';
    if (score >= 4) return 'text-yellow-700 dark:text-yellow-300';
    return 'text-red-700 dark:text-red-300';
}

// Update summary metrics
function updateValuationSummary(summary) {
    document.getElementById('estimated-value').textContent = summary.estimatedValue || '$0';
    document.getElementById('market-demand').textContent = `${summary.marketDemand || 0}/10`;
    document.getElementById('development-potential').textContent = `${summary.developmentPotential || 0}/10`;
    document.getElementById('brand-score').textContent = `${summary.brandScore || 0}/10`;
}

// Notification system
function showNotification(message, type = 'success') {
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 p-4 rounded shadow-md z-50 ${
        type === 'success' ? 'bg-green-100 text-green-700 border-l-4 border-green-500' :
        'bg-red-100 text-red-700 border-l-4 border-red-500'
    }`;
    notification.textContent = message;
    
    document.body.appendChild(notification);
    
    // Remove notification after 3 seconds
    setTimeout(() => {
        notification.remove();
    }, 3000);
}
