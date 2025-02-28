/**
 * Code Actions functionality (Copy & Download)
 * This module provides a reusable Alpine.js component for code action buttons
 */
export default function codeActions(config) {
    return {
        targetId: config.targetId,
        downloadName: config.downloadName || 'code',
        downloadExt: config.downloadExt || '.txt',
        copied: false,
        downloaded: false,

        /**
         * Copy code to clipboard
         */
        async copyToClipboard() {
            const codeElement = document.getElementById(this.targetId);
            if (!codeElement?.textContent) return;

            try {
                await navigator.clipboard.writeText(codeElement.textContent);
                this.showSuccess('copy');
                this.showNotification('Code copied to clipboard!', 'success');
            } catch (err) {
                this.showNotification('Failed to copy code', 'error');
            }
        },

        /**
         * Download code
         */
        downloadCode() {
            const codeElement = document.getElementById(this.targetId);
            if (!codeElement?.textContent) return;

            try {
                const blob = new Blob([codeElement.textContent], { type: 'text/plain' });
                const url = window.URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = this.downloadName + this.downloadExt;
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
                window.URL.revokeObjectURL(url);

                this.showSuccess('download');
                this.showNotification('Code downloaded successfully!', 'success');
            } catch (err) {
                this.showNotification('Failed to download code', 'error');
            }
        },

        /**
         * Show success state
         */
        showSuccess(type) {
            if (type === 'copy') {
                this.copied = true;
                setTimeout(() => this.copied = false, 1000);
            } else if (type === 'download') {
                this.downloaded = true;
                setTimeout(() => this.downloaded = false, 1000);
            }
        },

        /**
         * Show notification
         */
        showNotification(message, type = 'success') {
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 p-4 rounded shadow-md z-50 ${
                type === 'success' 
                    ? 'bg-green-100 text-green-700 border-l-4 border-green-500' 
                    : 'bg-red-100 text-red-700 border-l-4 border-red-500'
            }`;
            notification.textContent = message;
            
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.remove();
            }, 3000);
        }
    };
}