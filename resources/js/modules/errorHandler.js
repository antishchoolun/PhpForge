/**
 * Error Handler functionality
 * Provides methods to display error popups across the application
 */

/**
 * Show error popup for different types of errors
 */
export function showError(error) {
    //console.log('Error received:', error);

    // Remove any existing error popups
    document
        .querySelectorAll(".error-popup-container")
        .forEach((el) => el.remove());

    // Create container for the error
    const container = document.createElement("div");
    container.className = "error-popup-container";

    if (error.error === "Daily limit reached") {
        //console.log('Handling daily limit error');
        container.innerHTML = `
            <div class="fixed inset-0 flex items-center justify-center z-[9999]"
                 x-data="{ show: true }"
                 x-show="show"
                 x-transition:enter="transform transition-transform duration-300"
                 x-transition:enter-start="translate-y-full"
                 x-transition:enter-end="translate-y-0"
                 style="background-color: rgba(0, 0, 0, 0.5); backdrop-filter: blur(4px);">
                <div class="relative w-full max-w-lg mx-4">
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex items-center">
                            <div class="flex-shrink-0 w-10 h-10 rounded-full bg-yellow-100 dark:bg-yellow-900/30 flex items-center justify-center mr-3">
                                <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex-1">Daily Limit Reached</h3>
                            <button @click="show = false" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                        <div class="px-6 py-4">
                            <p class="text-gray-700 dark:text-gray-300">${error.message}</p>
                            <p class="mt-2 text-gray-600 dark:text-gray-400">Time remaining: ${error.remaining_time}</p>
                        </div>
                        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700/50 flex justify-end space-x-3">
                            <a href="/pricing" 
                               class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-md">
                                Upgrade Now
                            </a>
                            <button @click="show = false" 
                                    class="inline-flex justify-center px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-md border border-gray-300 dark:border-gray-600">
                                Close
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `;
    } else if (error.errors) {
        //console.log('Handling validation errors');
        const details = Object.entries(error.errors).map(
            ([field, messages]) => messages[0]
        );
        const errorList = details
            .map(
                (msg) =>
                    `<li class="text-gray-600 dark:text-gray-400">• ${msg}</li>`
            )
            .join("");

        container.innerHTML = `
            <div class="fixed inset-0 flex items-center justify-center z-[9999]"
                 x-data="{ show: true }"
                 x-show="show"
                 x-transition:enter="transform transition-transform duration-300"
                 x-transition:enter-start="translate-y-full"
                 x-transition:enter-end="translate-y-0"
                 style="background-color: rgba(0, 0, 0, 0.5); backdrop-filter: blur(4px);">
                <div class="relative w-full max-w-lg mx-4">
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex items-center">
                            <div class="flex-shrink-0 w-10 h-10 rounded-full bg-red-100 dark:bg-red-900/30 flex items-center justify-center mr-3">
                                <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex-1">Validation Error</h3>
                            <button @click="show = false" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                        <div class="px-6 py-4">
                            <p class="text-gray-700 dark:text-gray-300">Please fix the following issues:</p>
                            <ul class="mt-2 space-y-1">
                                ${errorList}
                            </ul>
                        </div>
                        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700/50 flex justify-end">
                            <button @click="show = false" 
                                    class="inline-flex justify-center px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-md border border-gray-300 dark:border-gray-600">
                                Close
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `;
    } else {
        //console.log('Handling generic error');
        container.innerHTML = `
            <div class="fixed inset-0 flex items-center justify-center z-[9999]"
                 x-data="{ show: true }"
                 x-show="show"
                 x-transition:enter="transform transition-transform duration-300"
                 x-transition:enter-start="translate-y-full"
                 x-transition:enter-end="translate-y-0"
                 style="background-color: rgba(0, 0, 0, 0.5); backdrop-filter: blur(4px);">
                <div class="relative w-full max-w-lg mx-4">
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex items-center">
                            <div class="flex-shrink-0 w-10 h-10 rounded-full bg-red-100 dark:bg-red-900/30 flex items-center justify-center mr-3">
                                <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex-1">Error</h3>
                            <button @click="show = false" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                        <div class="px-6 py-4">
                            <p class="text-gray-700 dark:text-gray-300">${
                                error.message || "An unexpected error occurred"
                            }</p>
                        </div>
                        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700/50 flex justify-end">
                            <button @click="show = false" 
                                    class="inline-flex justify-center px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-md border border-gray-300 dark:border-gray-600">
                                Close
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `;
    }

    // Add to DOM
    document.body.appendChild(container);

    // Initialize Alpine.js on the new element
    //console.log('Initializing Alpine.js on error popup');
    window.Alpine.initTree(container);
}
