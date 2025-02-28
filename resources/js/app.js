import "./bootstrap";
import Alpine from "alpinejs";
import "../css/app.css";
import { initModals, openModal, closeModal } from "./modules/modals";
import { initCodeGenerator } from "./modules/codeGenerator";
import codeActions from "./modules/codeActions";
import { setupCopyButtons } from "./modules/clipboard";
import { showError } from "./modules/errorHandler";

// Register Alpine.js components
Alpine.data("codeActions", codeActions);

// Make functions globally available
window.Alpine = Alpine;
window.openModal = openModal;
window.closeModal = closeModal;
window.showError = showError;

// Initialize Alpine.js
Alpine.start();

// Initialize all components when DOM is loaded
document.addEventListener("DOMContentLoaded", () => {
    initModals();
    initCodeGenerator();
    setupCopyButtons();
});