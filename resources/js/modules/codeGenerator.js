/**
 * Code Generator functionality
 */
export function initCodeGenerator() {
    const generateBtn = document.getElementById('generate-code-btn');
    if (!generateBtn) return;

    window.simulateCodeGeneration = function() {
        const codeResult = document.getElementById('code-result');
        
        // Show loading state
        generateBtn.innerHTML = '<span class="spinner"></span> Generating...';
        generateBtn.disabled = true;
        
        // Simulate API call delay
        setTimeout(() => {
            // Hide loading and show result
            generateBtn.innerHTML = 'Generate Code';
            generateBtn.disabled = false;
            
            if (codeResult) {
                codeResult.style.display = 'block';
                // Scroll to result with smooth animation
                codeResult.scrollIntoView({ 
                    behavior: 'smooth',
                    block: 'nearest'
                });
            }

            // Show success message
            showNotification('Code generated successfully!', 'success');
        }, 1500);
    };

    // Notification system
    window.showNotification = function(message, type = 'success') {
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
    };

    // Handle form submission
    const form = document.getElementById('code-generator-form');
    if (form) {
        form.addEventListener('submit', (e) => {
            e.preventDefault();
            simulateCodeGeneration();
        });
    }
}