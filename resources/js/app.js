import './bootstrap';
import '../css/app.css';
import { initModals } from './modules/modals';
import { initCodeGenerator } from './modules/codeGenerator';
import { setupCopyButtons } from './modules/clipboard';

// Initialize all components when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    initModals();
    initCodeGenerator();
    setupCopyButtons();
});
