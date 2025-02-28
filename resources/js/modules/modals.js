/**
 * Modal functionality
 */

// Open modal handler
export function openModal(modalName) {
    const modal = document.getElementById(`${modalName}-modal`);
    if (modal) {
        modal.classList.add('active');
        document.body.style.overflow = 'hidden';
    }
}

// Close modal handler
export function closeModal(modalName) {
    const modal = document.getElementById(`${modalName}-modal`);
    if (modal) {
        modal.classList.remove('active');
        document.body.style.overflow = '';
    }
}

// Initialize modal functionality
export function initModals() {

    // Close modal when clicking outside
    document.addEventListener("click", (e) => {
        const modals = document.querySelectorAll(".modal");
        modals.forEach((modal) => {
            if (e.target === modal) {
                modal.classList.remove("active");
                document.body.style.overflow = "";
            }
        });
    });

    // Close modal with Escape key
    document.addEventListener("keydown", (e) => {
        if (e.key === "Escape") {
            const activeModal = document.querySelector(".modal.active");
            if (activeModal) {
                activeModal.classList.remove("active");
                document.body.style.overflow = "";
            }
        }
    });
}
