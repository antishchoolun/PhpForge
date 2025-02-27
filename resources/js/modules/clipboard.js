/**
 * Clipboard functionality for code copying
 */
export function setupCopyButtons() {
    document.querySelectorAll('.code-area-tools button[title="Copy code"]').forEach(button => {
        button.addEventListener('click', async () => {
            const codeBlock = button.closest('.code-area').querySelector('code');
            if (!codeBlock) return;

            try {
                await navigator.clipboard.writeText(codeBlock.textContent);
                
                // Show success state
                const originalContent = button.innerHTML;
                button.innerHTML = `
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="20 6 9 17 4 12"></polyline>
                    </svg>
                `;
                
                // Reset after 2 seconds
                setTimeout(() => {
                    button.innerHTML = originalContent;
                }, 2000);

                // Show success notification
                showNotification('Code copied to clipboard!', 'success');
            } catch (err) {
                console.error('Failed to copy code:', err);
                showNotification('Failed to copy code', 'error');
            }
        });
    });

    // Handle download buttons
    document.querySelectorAll('.code-area-tools button[title="Download"]').forEach(button => {
        button.addEventListener('click', () => {
            const codeBlock = button.closest('.code-area').querySelector('code');
            if (!codeBlock) return;

            const blob = new Blob([codeBlock.textContent], { type: 'text/plain' });
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'generated-code.php';
            a.click();
            window.URL.revokeObjectURL(url);
        });
    });
}