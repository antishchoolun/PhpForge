/**
 * Error Handler functionality
 * Provides methods to display error popups across the application
 */

/**
 * Show error popup for different types of errors
 */
export function showError(error) {
    // Remove any existing error popups
    document.querySelectorAll('.error-popup-container').forEach(el => el.remove());

    let popupHtml = '';

    if (error.error === 'Daily limit reached') {
        // Handle daily limit error
        popupHtml = `
            <x-error-popup
                type="warning"
                title="Daily Limit Reached"
                message="${error.message}"
                :details="['Time remaining: ${error.remaining_time}']"
                action="Upgrade Now"
                action-url="/pricing"
            />
        `;
    } else if (error.errors) {
        // Handle validation errors
        const details = Object.entries(error.errors).map(([field, messages]) => messages[0]);
        popupHtml = `
            <x-error-popup
                type="error"
                title="Validation Error"
                message="Please fix the following issues:"
                :details='${JSON.stringify(details)}'
            />
        `;
    } else {
        // Handle generic errors
        popupHtml = `
            <x-error-popup
                type="error"
                title="Error"
                message="${error.message || 'An unexpected error occurred'}"
            />
        `;
    }

    // Create container for the popup
    const container = document.createElement('div');
    container.className = 'error-popup-container';
    container.innerHTML = popupHtml;
    document.body.appendChild(container);

    // Initialize Alpine.js on the new element
    window.Alpine.initTree(container);
}