/**
 * Code Generator functionality
 */
export function initCodeGenerator() {
    const form = document.getElementById('code-generator-form');
    const generateBtn = document.getElementById('generate-code-btn');
    const codeResult = document.getElementById('code-result');
    
    if (!form || !generateBtn) return;

    // Handle form submission
    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        
        // Get form data
        const prompt = document.getElementById('code-prompt').value;
        const language = document.getElementById('language').value;
        const options = Array.from(form.querySelectorAll('input[name="options[]"]:checked'))
            .map(checkbox => checkbox.value);
        
        // Show loading state
        generateBtn.innerHTML = '<span class="spinner"></span> Generating...';
        generateBtn.disabled = true;
        
        try {
            // Make API request
            const response = await fetch('/tools/code-generator/generate', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    prompt,
                    language,
                    options
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
                    codeResult.style.display = 'block';
                    
                    // Update analysis based on code characteristics
                    const analysisContent = generateAnalysis(result.code, language);
                    const consoleContent = document.querySelector('.console-content');
                    if (consoleContent) {
                        consoleContent.innerHTML = analysisContent;
                    }

                    // Scroll to result
                    codeResult.scrollIntoView({ 
                        behavior: 'smooth',
                        block: 'nearest'
                    });
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

    // Handle code copying
    const copyBtn = document.querySelector('.code-area-tools button[title="Copy code"]');
    if (copyBtn) {
        copyBtn.addEventListener('click', () => {
            const code = document.getElementById('generated-code');
            if (code) {
                navigator.clipboard.writeText(code.textContent)
                    .then(() => showNotification('Code copied to clipboard!', 'success'))
                    .catch(() => showNotification('Failed to copy code', 'error'));
            }
        });
    }

    // Handle code downloading
    const downloadBtn = document.querySelector('.code-area-tools button[title="Download"]');
    if (downloadBtn) {
        downloadBtn.addEventListener('click', () => {
            const code = document.getElementById('generated-code');
            if (code) {
                const language = document.getElementById('language').value;
                const extensions = {
                    php: '.php',
                    javascript: '.js',
                    python: '.py',
                    java: '.java',
                    cpp: '.cpp',
                    csharp: '.cs'
                };
                
                const blob = new Blob([code.textContent], { type: 'text/plain' });
                const url = window.URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = `generated-code${extensions[language] || '.txt'}`;
                a.click();
                window.URL.revokeObjectURL(url);
            }
        });
    }
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
            
        // Add more language-specific checks as needed
    }

    // Generate HTML for analysis
    return analysis.map(item => `
        <div class="console-line">
            <span class="console-prefix">${item.type === 'success' ? '✓' : 'ℹ'}</span>
            <span>${item.message}</span>
        </div>
    `).join('');
}