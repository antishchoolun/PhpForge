/**
 * Security Analysis functionality
 */
import { showError } from './errorHandler';

export function initSecurityAnalyzer() {
    const form = document.getElementById('security-analyzer-form');
    const analyzeBtn = document.getElementById('analyze-security-btn');
    const securityResult = document.getElementById('security-result');
    const mainContent = document.querySelector('.modal-content > .h-full > div:nth-child(2)');
    
    if (!form || !analyzeBtn) return;

    // Handle form submission
    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        
        // Get form data
        const code = document.getElementById('code-input').value;
        const checks = Array.from(form.querySelectorAll('input[name="checks[]"]:checked'))
            .map(checkbox => checkbox.value);
        const riskLevel = document.getElementById('risk-level').value;
        
        // Show quantum loader
        window.dispatchEvent(new CustomEvent('analyzing-security'));
        
        // Show loading state
        const originalBtnText = analyzeBtn.innerHTML;
        analyzeBtn.innerHTML = '<span class="spinner"></span> Analyzing...';
        analyzeBtn.disabled = true;
        
        try {
            // Make API request
            const response = await fetch('/tools/security-analyze', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    code,
                    checks,
                    riskLevel
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
            const reportContent = formatSecurityResults(result.vulnerabilities);
            const reportElement = document.getElementById('security-report');
            if (reportElement) {
                reportElement.innerHTML = reportContent;
            }

            // Update summary counts
            updateSecuritySummary(result.summary);

            // Show the result container with animation
            if (securityResult) {
                securityResult.classList.add('animate__animated', 'animate__fadeInRight');
                securityResult.classList.remove('hidden');
                mainContent.classList.remove('grid-cols-1');
                mainContent.classList.add('flex', 'flex-row');

                // Remove animation classes after animation completes
                securityResult.addEventListener('animationend', () => {
                    securityResult.classList.remove('animate__animated', 'animate__fadeInRight');
                }, { once: true });
            }

            showNotification('Security analysis completed!', 'success');

        } catch (error) {
            showError({
                message: error.message || 'An unexpected error occurred during security analysis'
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

// Format security results into HTML
function formatSecurityResults(vulnerabilities) {
    if (!vulnerabilities || !Array.isArray(vulnerabilities)) return '';

    const severityClasses = {
        high: 'border-red-500 bg-red-50 dark:bg-red-900/20',
        medium: 'border-orange-500 bg-orange-50 dark:bg-orange-900/20',
        low: 'border-yellow-500 bg-yellow-50 dark:bg-yellow-900/20',
        info: 'border-blue-500 bg-blue-50 dark:bg-blue-900/20'
    };

    const severityTextClasses = {
        high: 'text-red-700 dark:text-red-300',
        medium: 'text-orange-700 dark:text-orange-300',
        low: 'text-yellow-700 dark:text-yellow-300',
        info: 'text-blue-700 dark:text-blue-300'
    };

    return vulnerabilities.map(vuln => `
        <div class="vulnerability-item border-l-4 rounded-lg p-4 ${severityClasses[vuln.severity]}">
            <div class="flex items-start gap-3">
                <div class="flex-1 space-y-1">
                    <div class="flex items-center gap-2">
                        <span class="px-2 py-1 text-xs font-medium rounded-full ${severityTextClasses[vuln.severity]} bg-white/50 dark:bg-black/20">
                            ${vuln.severity.toUpperCase()}
                        </span>
                        <h4 class="font-medium text-gray-900 dark:text-white">
                            ${vuln.title}
                        </h4>
                    </div>
                    <p class="text-gray-600 dark:text-gray-300">
                        ${vuln.description}
                    </p>
                    ${vuln.location ? `
                        <div class="mt-2 text-sm">
                            <span class="font-medium">Location:</span>
                            <span class="font-mono">${vuln.location}</span>
                        </div>
                    ` : ''}
                    ${vuln.recommendation ? `
                        <div class="mt-2 p-3 bg-white dark:bg-gray-800 rounded">
                            <span class="font-medium ${severityTextClasses[vuln.severity]}">Recommendation:</span>
                            <p class="mt-1 text-gray-700 dark:text-gray-300">${vuln.recommendation}</p>
                        </div>
                    ` : ''}
                    ${vuln.code ? `
                        <pre class="mt-2 p-2 bg-gray-50 dark:bg-gray-900 rounded text-sm overflow-x-auto">
                            <code class="text-gray-800 dark:text-gray-200">${vuln.code}</code>
                        </pre>
                    ` : ''}
                </div>
            </div>
        </div>
    `).join('');
}

// Update summary counts
function updateSecuritySummary(summary) {
    document.getElementById('high-risk-count').textContent = summary.high || 0;
    document.getElementById('medium-risk-count').textContent = summary.medium || 0;
    document.getElementById('low-risk-count').textContent = summary.low || 0;
    document.getElementById('info-count').textContent = summary.info || 0;
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
