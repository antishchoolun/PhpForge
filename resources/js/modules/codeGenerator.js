/**
 * Code Generator functionality
 */
export function initCodeGenerator() {
    const form = document.getElementById('code-generator-form');
    const generateBtn = document.getElementById('generate-code-btn');
    const codeResult = document.getElementById('code-result');
    const mainContent = document.querySelector('.modal-content > .h-full > div:nth-child(2)');
    
    if (!form || !generateBtn) return;

    // Handle form submission
    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        
        // Get form data
        const prompt = document.getElementById('code-prompt').value;
        const framework = document.getElementById('framework').value;
        const component = form.querySelector('input[name="component"]:checked').value;
        const patterns = Array.from(form.querySelectorAll('input[name="patterns[]"]:checked'))
            .map(checkbox => checkbox.value);
        const phpVersion = form.querySelector('input[name="php_version"]:checked').value;
        
        // Show loading state
        generateBtn.innerHTML = '<span class="spinner"></span> Generating...';
        generateBtn.disabled = true;
        
        try {
            // Make API request
            const response = await fetch('/tools/generate', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    prompt,
                    framework,
                    component,
                    patterns,
                    phpVersion
                })
            });

            const result = await response.json();

            if (!result.success) {
                throw new Error(result.error || 'Failed to generate code');
            }

            // Update code display
            const codeElement = document.getElementById('generated-code');
            if (codeElement) {
                codeElement.textContent = result.code;
                
                // Show the result container
                if (codeResult) {
                    // Update classes for visibility
                    codeResult.classList.remove('hidden');
                    mainContent.classList.remove('grid-cols-1');
                    mainContent.classList.add('flex', 'flex-row');
                    
                    // Update analysis based on code characteristics
                    const analysisContent = generateAnalysis(result.code, 'php');
                    const consoleContent = document.querySelector('.console-content');
                    if (consoleContent) {
                        consoleContent.innerHTML = analysisContent;
                    }
                }
            }

            showNotification('Code generated successfully!', 'success');

        } catch (error) {
            showNotification(error.message, 'error');
        } finally {
            // Reset button state
            generateBtn.innerHTML = 'Generate Code';
            generateBtn.disabled = false;
        }
    });
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

// Generate analysis based on code content
function generateAnalysis(code, language) {
    const analysis = [];
    
    // Check for comments
    if (code.includes('/**') || code.includes('//') || code.includes('#')) {
        analysis.push({
            type: 'success',
            message: 'Documentation and comments included'
        });
    }

    // Check for error handling
    if (code.includes('try') && code.includes('catch')) {
        analysis.push({
            type: 'success',
            message: 'Error handling implemented with try/catch'
        });
    }

    // Language-specific checks
    switch (language) {
        case 'php':
            if (code.includes('PDO')) {
                analysis.push({
                    type: 'success',
                    message: 'Using PDO for database connections (secure practice)'
                });
            }
            if (code.includes('prepare(') && code.includes('execute(')) {
                analysis.push({
                    type: 'success',
                    message: 'Prepared statements prevent SQL injection'
                });
            }
            break;
            
        case 'javascript':
            if (code.includes('async') || code.includes('Promise')) {
                analysis.push({
                    type: 'success',
                    message: 'Asynchronous code handling implemented'
                });
            }
            break;
    }

    // Generate HTML for analysis
    return analysis.map(item => `
        <div class="console-line">
            <span class="console-prefix">${item.type === 'success' ? '✓' : 'ℹ'}</span>
            <span>${item.message}</span>
        </div>
    `).join('');
}
