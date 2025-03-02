/**
 * Performance Optimization functionality
 */
import { showError } from './errorHandler';

export function initPerformanceOptimizer() {
    const form = document.getElementById('performance-optimizer-form');
    const analyzeBtn = document.getElementById('analyze-performance-btn');
    const performanceResult = document.getElementById('performance-result');
    const mainContent = document.querySelector('.modal-content > .h-full > div:nth-child(2)');
    
    if (!form || !analyzeBtn) return;

    // Handle form submission
    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        e.stopPropagation(); // Ensure no other handlers interfere
        
        // Get form data
        const formData = new FormData(form);
        const code = formData.get('code') || '';
        const environment = formData.get('environment') || 'staging';
        const optimizations = Array.from(form.querySelectorAll('input[name="optimizations[]"]:checked'))
            .map(checkbox => checkbox.value);

        // Client-side validation
        if (!code.trim()) {
            showError({
                message: 'Please enter code to analyze'
            });
            return;
        }

        if (optimizations.length === 0) {
            showError({
                message: 'Please select at least one optimization focus'
            });
            return;
        }

        // Log data being sent (for debugging)
        console.log('Submitting performance analysis:', {
            code: code.trim(),
            optimizations,
            environment
        });
        
        // Show quantum loader
        window.dispatchEvent(new CustomEvent('analyzing-performance'));
        
        // Show loading state
        const originalBtnText = analyzeBtn.innerHTML;
        analyzeBtn.innerHTML = '<span class="spinner"></span> Analyzing...';
        analyzeBtn.disabled = true;
        
        try {
            // Make API request
            const response = await fetch('/tools/performance-optimize', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    code: code.trim(),
                    optimizations,
                    environment
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
            const reportContent = formatPerformanceResults(result.issues);
            const reportElement = document.getElementById('performance-report');
            if (reportElement) {
                reportElement.innerHTML = reportContent;
            }

            // Update summary counts
            updatePerformanceSummary(result.summary);

            // Show the result container with animation
            if (performanceResult) {
                performanceResult.classList.add('animate__animated', 'animate__fadeInRight');
                performanceResult.classList.remove('hidden');
                mainContent.classList.remove('grid-cols-1');
                mainContent.classList.add('flex', 'flex-row');

                // Remove animation classes after animation completes
                performanceResult.addEventListener('animationend', () => {
                    performanceResult.classList.remove('animate__animated', 'animate__fadeInRight');
                }, { once: true });
            }

            showNotification('Performance analysis completed!', 'success');

        } catch (error) {
            showError({
                message: error.message || 'An unexpected error occurred during performance analysis'
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

// Format performance results into HTML
function formatPerformanceResults(issues) {
    if (!issues || !Array.isArray(issues)) return '';

    const severityClasses = {
        critical: 'border-red-500 bg-red-50 dark:bg-red-900/20',
        major: 'border-orange-500 bg-orange-50 dark:bg-orange-900/20',
        minor: 'border-yellow-500 bg-yellow-50 dark:bg-yellow-900/20',
        optimization: 'border-green-500 bg-green-50 dark:bg-green-900/20'
    };

    const severityTextClasses = {
        critical: 'text-red-700 dark:text-red-300',
        major: 'text-orange-700 dark:text-orange-300',
        minor: 'text-yellow-700 dark:text-yellow-300',
        optimization: 'text-green-700 dark:text-green-300'
    };

    return issues.map(issue => `
        <div class="performance-item border-l-4 rounded-lg p-4 ${severityClasses[issue.severity]}">
            <div class="flex items-start gap-3">
                <div class="flex-1 space-y-1">
                    <div class="flex items-center gap-2">
                        <span class="px-2 py-1 text-xs font-medium rounded-full ${severityTextClasses[issue.severity]} bg-white/50 dark:bg-black/20">
                            ${issue.severity.toUpperCase()}
                        </span>
                        <h4 class="font-medium text-gray-900 dark:text-white">
                            ${issue.title}
                        </h4>
                    </div>
                    <p class="text-gray-600 dark:text-gray-300">
                        ${issue.description}
                    </p>
                    ${issue.impact ? `
                        <div class="mt-2 text-sm">
                            <span class="font-medium">Performance Impact:</span>
                            <span class="font-mono">${issue.impact}</span>
                        </div>
                    ` : ''}
                    ${issue.solution ? `
                        <div class="mt-2 p-3 bg-white dark:bg-gray-800 rounded">
                            <span class="font-medium ${severityTextClasses[issue.severity]}">Recommendation:</span>
                            <p class="mt-1 text-gray-700 dark:text-gray-300">${issue.solution}</p>
                        </div>
                    ` : ''}
                    ${issue.code ? `
                        <pre class="mt-2 p-2 bg-gray-50 dark:bg-gray-900 rounded text-sm overflow-x-auto">
                            <code class="text-gray-800 dark:text-gray-200">${issue.code}</code>
                        </pre>
                    ` : ''}
                </div>
            </div>
        </div>
    `).join('');
}

// Update summary counts
function updatePerformanceSummary(summary) {
    document.getElementById('critical-issues').textContent = summary.critical || 0;
    document.getElementById('major-issues').textContent = summary.major || 0;
    document.getElementById('minor-issues').textContent = summary.minor || 0;
    document.getElementById('optimizations').textContent = summary.optimization || 0;
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
