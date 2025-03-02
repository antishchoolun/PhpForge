/**
 * Documentation Generator functionality
 */
import { showError } from './errorHandler';

export function initDocumentationGenerator() {
    const form = document.getElementById('documentation-generator-form');
    const generateBtn = document.getElementById('generate-docs-btn');
    const docResult = document.getElementById('documentation-result');
    const mainContent = document.querySelector('.modal-content > .h-full > div:nth-child(2)');
    
    if (!form || !generateBtn) return;

    // Handle form submission
    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        e.stopPropagation(); // Ensure no other handlers interfere
        
        // Get form data
        const formData = new FormData(form);
        const code = formData.get('code') || '';
        const style = formData.get('style') || 'phpdoc';
        const format = formData.get('format') || 'inline';
        const sections = Array.from(form.querySelectorAll('input[name="sections[]"]:checked'))
            .map(checkbox => checkbox.value);

        // Client-side validation
        if (!code.trim()) {
            showError({
                message: 'Please enter code to document'
            });
            return;
        }

        if (sections.length === 0) {
            showError({
                message: 'Please select at least one documentation section'
            });
            return;
        }

        // Log data being sent (for debugging)
        console.log('Submitting documentation generation request:', {
            code: code.trim(),
            style,
            format,
            sections
        });
        
        // Show quantum loader
        window.dispatchEvent(new CustomEvent('generating-docs'));
        
        // Show loading state
        const originalBtnText = generateBtn.innerHTML;
        generateBtn.innerHTML = '<span class="spinner"></span> Generating...';
        generateBtn.disabled = true;
        
        try {
            // Make API request
            const response = await fetch('/tools/generate-docs', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    code: code.trim(),
                    style,
                    format,
                    sections
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
            const docContent = formatDocumentation(result.documentation, format);
            const contentElement = document.getElementById('documentation-content');
            if (contentElement) {
                contentElement.innerHTML = docContent;
            }

            // Update summary counts
            updateDocumentationSummary(result.summary);

            // Show the result container with animation
            if (docResult) {
                docResult.classList.add('animate__animated', 'animate__fadeInRight');
                docResult.classList.remove('hidden');
                mainContent.classList.remove('grid-cols-1');
                mainContent.classList.add('flex', 'flex-row');

                // Remove animation classes after animation completes
                docResult.addEventListener('animationend', () => {
                    docResult.classList.remove('animate__animated', 'animate__fadeInRight');
                }, { once: true });
            }

            showNotification('Documentation generated successfully!', 'success');

        } catch (error) {
            showError({
                message: error.message || 'An unexpected error occurred during documentation generation'
            });
        } finally {
            // Hide quantum loader
            window.dispatchEvent(new CustomEvent('generation-complete'));
            
            // Reset button state
            generateBtn.innerHTML = originalBtnText;
            generateBtn.disabled = false;
        }
    });
}

// Format documentation based on selected format
function formatDocumentation(documentation, format) {
    // Check if documentation is already in HTML format
    if (documentation.trim().startsWith('<')) {
        return documentation;
    }

    // Convert different formats to HTML
    switch (format) {
        case 'markdown':
            return `<pre class="markdown-content font-mono whitespace-pre-wrap text-gray-800 dark:text-gray-200">${documentation}</pre>`;
        
        case 'phpdoc':
            return `<pre class="phpdoc-content font-mono whitespace-pre-wrap text-gray-800 dark:text-gray-200">${documentation}</pre>`;
        
        case 'wiki':
            return `<div class="wiki-content prose dark:prose-invert max-w-none">${documentation}</div>`;
        
        case 'readme':
            return `<div class="readme-content prose dark:prose-invert max-w-none">${documentation}</div>`;
        
        default:
            return `<pre class="documentation-content font-mono whitespace-pre-wrap text-gray-800 dark:text-gray-200">${documentation}</pre>`;
    }
}

// Update summary statistics
function updateDocumentationSummary(summary) {
    document.getElementById('doc-sections').textContent = summary.sections || 0;
    document.getElementById('doc-lines').textContent = summary.lines || 0;
    document.getElementById('doc-coverage').textContent = `${summary.coverage || 0}%`;
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
