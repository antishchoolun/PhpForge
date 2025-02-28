import "./bootstrap";
import Alpine from "alpinejs";
import "../css/app.css";
import { initModals, openModal, closeModal } from "./modules/modals";
import { initCodeGenerator } from "./modules/codeGenerator";
import { setupCopyButtons } from "./modules/clipboard";

window.Alpine = Alpine;
Alpine.start();

// Make modal functions globally available
window.openModal = openModal;
window.closeModal = closeModal;

// Initialize all components when DOM is loaded
document.addEventListener("DOMContentLoaded", () => {
    initModals();
    initCodeGenerator();
    setupCopyButtons();
});
