// Modal functionality
class Modal {
    constructor(modalName) {
        this.modalElement = document.getElementById(`${modalName}-modal`);
    }

    open() {
        this.modalElement.classList.add('active');
    }

    close() {
        this.modalElement.classList.remove('active');
    }
}

// Code Generator functionality
class CodeGenerator {
    constructor() {
        this.generateBtn = document.getElementById('generate-code-btn');
        this.codeResult = document.getElementById('code-result');
        this.bindEvents();
    }

    bindEvents() {
        this.generateBtn.addEventListener('click', () => this.generateCode());
    }

    generateCode() {
        this.setLoadingState(true);
        
        // Simulate API call delay
        setTimeout(() => {
            this.setLoadingState(false);
            this.showResult();
        }, 1500);
    }

    setLoadingState(isLoading) {
        if (isLoading) {
            this.generateBtn.innerHTML = '<span class="spinner"></span> Generating...';
            this.generateBtn.disabled = true;
        } else {
            this.generateBtn.innerHTML = 'Generate Code';
            this.generateBtn.disabled = false;
        }
    }

    showResult() {
        this.codeResult.style.display = 'block';
        this.codeResult.scrollIntoView({ behavior: 'smooth' });
    }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    // Initialize modals
    const modals = ['code-generator', 'debugging', 'security', 'performance', 'documentation', 'domain-valuation'];
    const modalInstances = {};

    modals.forEach(modalName => {
        modalInstances[modalName] = new Modal(modalName);
    });

    // Global modal functions
    window.openModal = (modalName) => {
        modalInstances[modalName].open();
    };

    window.closeModal = (modalName) => {
        modalInstances[modalName].close();
    };

    // Close modals when clicking outside
    window.addEventListener('click', (e) => {
        modals.forEach(modalName => {
            if (e.target === modalInstances[modalName].modalElement) {
                modalInstances[modalName].close();
            }
        });
    });

    // Initialize code generator
    new CodeGenerator();
});