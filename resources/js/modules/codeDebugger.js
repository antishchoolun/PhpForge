/**
 * Code Debugger functionality
 */
import { showError } from './errorHandler';

export function initCodeDebugger() {
    const form = document.getElementById('code-debugger-form');
    const debugBtn = document.getElementById('debug-code-btn');
    const debugResult = document.getElementById('debug-result');
    const mainContent = document.querySelector('.modal-content > .h-full > div:nth-child(2)');
    
    if (!form || !debugBtn) return;

    // Handle form submission
    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        
        // Get form data
        const code = document.getElementById('code-input').value;
        const errorDescription = document.getElementById('error-description').value;
        const options = Array.from(form.querySelectorAll('input[name="options[]"]:checked'))
            .map(checkbox => checkbox.value);
        
        // Show quantum loader
        window.dispatchEvent(new CustomEvent('analyzing-code'));
        
        // Show loading state
        const originalBtnText = debugBtn.innerHTML;
        debugBtn.innerHTML = '<span class="spinner"></span> Analyzing...';
        debugBtn.disabled = true;
        
        try {
            // Make API request
            const response = await fetch('/tools/debug', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    code,
                    errorDescription,
                    options
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

            // Format the analysis results
            const analysisContent = formatAnalysisResults(result.analysis);
            const analysisElement = document.getElementById('analysis-result');
            if (analysisElement) {
                analysisElement.innerHTML = analysisContent;
            }

            // Update fixed code preview if available
            const fixedCodeElement = document.getElementById('fixed-code');
            if (fixedCodeElement && result.fixedCode) {
                fixedCodeElement.textContent = result.fixedCode;
            }

            // Show the result container with animation
            if (debugResult) {
                debugResult.classList.add('animate__animated', 'animate__fadeInRight');
                debugResult.classList.remove('hidden');
                mainContent.classList.remove('grid-cols-1');
                mainContent.classList.add('flex', 'flex-row');

                // Remove animation classes after animation completes
                debugResult.addEventListener('animationend', () => {
                    debugResult.classList.remove('animate__animated', 'animate__fadeInRight');
                }, { once: true });
            }

            showNotification('Code analysis completed!', 'success');

        } catch (error) {
            showError({
                message: error.message || 'An unexpected error occurred during code analysis'
            });
        } finally {
            // Hide quantum loader
            window.dispatchEvent(new CustomEvent('analysis-complete'));
            
            // Reset button state
            debugBtn.innerHTML = originalBtnText;
            debugBtn.disabled = false;
        }
    });
}

// Format analysis results into HTML
function formatAnalysisResults(analysis) {
    if (!analysis || !Array.isArray(analysis)) return '';

    const severityClasses = {
        error: 'text-red-600 dark:text-red-400',
        warning: 'text-yellow-600 dark:text-yellow-400',
        info: 'text-blue-600 dark:text-blue-400',
        success: 'text-green-600 dark:text-green-400'
    };

    const severityIcons = {
        error: '❌',
        warning: '⚠️',
        info: 'ℹ️',
        success: '✅'
    };

    return analysis.map(item => `
        <div class="analysis-item bg-white dark:bg-gray-800 rounded-lg shadow p-4 ${item.severity === 'error' ? 'border-l-4 border-red-500' : ''}">
            <div class="flex items-start gap-3">
                <span class="flex-shrink-0 ${severityClasses[item.severity] || severityClasses.info}">
                    ${severityIcons[item.severity] || severityIcons.info}
                </span>
                <div class="flex-1 space-y-1">
                    <h4 class="font-medium text-gray-900 dark:text-white">
                        ${item.title}
                    </h4>
                    <p class="text-gray-600 dark:text-gray-300">
                        ${item.message}
                    </p>
                    ${item.suggestion ? `
                        <div class="mt-2 text-sm">
                            <span class="font-medium text-indigo-600 dark:text-indigo-400">Suggestion:</span>
                            <span class="text-gray-700 dark:text-gray-300">${item.suggestion}</span>
                        </div>
                    ` : ''}
                    ${item.code ? `
                        <pre class="mt-2 p-2 bg-gray-50 dark:bg-gray-900 rounded text-sm overflow-x-auto">
                            <code class="text-gray-800 dark:text-gray-200">${item.code}</code>
                        </pre>
                    ` : ''}
                </div>
            </div>
        </div>
    `).join('');
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
