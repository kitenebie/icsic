/**
 * Auto-Save Draft System
 * A comprehensive utility for automatic form draft saving and restoration
 *
 * Features:
 * - Automatic saving on form changes
 * - Debounced saving to prevent excessive operations
 * - Draft restoration with user confirmation
 * - Cross-session persistence using localStorage
 * - Support for file uploads and complex data structures
 * - Error handling and data validation
 * - Event-driven architecture for extensibility
 */

class AutoSaveDraft {
    constructor(options = {}) {
        this.options = {
            draftKey: 'formDraft',
            saveDelay: 1000, // 1 second delay
            maxRetries: 3,
            enableNotifications: true,
            excludeFields: ['_token', 'password', 'password_confirmation'],
            includeFiles: false, // Set to true to include file data
            ...options
        };

        this.saveTimeout = null;
        this.isInitialized = false;
        this.eventListeners = [];
        this.draftData = null;

        this.init();
    }

    /**
     * Initialize the auto-save system
     */
    init() {
        if (this.isInitialized) return;

        console.log(`🚀 Initializing Auto-Save Draft System for: ${this.options.draftKey}`);

        this.checkForExistingDraft();
        this.setupEventListeners();
        this.setupFormWatcher();

        this.isInitialized = true;
        this.emit('initialized', { draftKey: this.options.draftKey });
    }

    /**
     * Check for existing draft on page load
     */
    checkForExistingDraft() {
        try {
            const saved = localStorage.getItem(this.options.draftKey);
            if (saved) {
                this.draftData = JSON.parse(saved);
                if (this.hasValidDraft()) {
                    this.showDraftNotification();
                    this.emit('draftFound', this.draftData);
                }
            }
        } catch (error) {
            console.error('❌ Error checking for existing draft:', error);
            this.clearDraft();
        }
    }

    /**
     * Check if draft contains valid data
     */
    hasValidDraft() {
        if (!this.draftData || typeof this.draftData !== 'object') return false;

        // Check if draft has meaningful data (excluding excluded fields)
        const meaningfulKeys = Object.keys(this.draftData).filter(key =>
            !this.options.excludeFields.includes(key) &&
            this.draftData[key] !== null &&
            this.draftData[key] !== undefined &&
            this.draftData[key] !== ''
        );

        return meaningfulKeys.length > 0;
    }

    /**
     * Show draft notification to user
     */
    showDraftNotification() {
        const notification = this.createDraftNotification();
        document.body.appendChild(notification);

        // Auto-hide after 10 seconds
        setTimeout(() => {
            if (notification.parentNode) {
                notification.remove();
            }
        }, 10000);
    }

    /**
     * Create draft notification element
     */
    createDraftNotification() {
        const notification = document.createElement('div');
        notification.id = 'draft-notification';
        notification.className = 'fixed top-4 right-4 z-50 max-w-sm';
        notification.innerHTML = `
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 shadow-lg">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <div class="ml-3 w-0 flex-1">
                        <p class="text-sm font-medium text-blue-800">Draft Found</p>
                        <p class="mt-1 text-sm text-blue-600">You have unsaved form data from a previous session.</p>
                        <div class="mt-3 flex space-x-2">
                            <button id="restore-draft-btn" class="px-3 py-1 bg-blue-600 text-white text-sm rounded hover:bg-blue-700 transition-colors">
                                Restore Draft
                            </button>
                            <button id="dismiss-draft-btn" class="px-3 py-1 bg-gray-300 text-gray-700 text-sm rounded hover:bg-gray-400 transition-colors">
                                Dismiss
                            </button>
                        </div>
                    </div>
                    <div class="ml-4 flex-shrink-0 flex">
                        <button id="close-draft-notification" class="inline-flex text-blue-400 hover:text-blue-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        `;

        // Add event listeners
        notification.querySelector('#restore-draft-btn').addEventListener('click', () => {
            this.restoreDraft();
            notification.remove();
        });

        notification.querySelector('#dismiss-draft-btn').addEventListener('click', () => {
            this.clearDraft();
            notification.remove();
        });

        notification.querySelector('#close-draft-notification').addEventListener('click', () => {
            notification.remove();
        });

        return notification;
    }

    /**
     * Setup event listeners for form changes
     */
    setupEventListeners() {
        // Listen for input changes
        document.addEventListener('input', (e) => {
            if (this.shouldTrackElement(e.target)) {
                this.scheduleSave();
            }
        });

        // Listen for select changes
        document.addEventListener('change', (e) => {
            if (this.shouldTrackElement(e.target)) {
                this.scheduleSave();
            }
        });

        // Listen for form submission to clear draft
        document.addEventListener('submit', (e) => {
            if (e.target.matches('form')) {
                this.clearDraft();
            }
        });
    }

    /**
     * Check if element should be tracked for changes
     */
    shouldTrackElement(element) {
        if (!element) return false;

        // Skip excluded fields
        if (this.options.excludeFields.includes(element.name)) return false;

        // Only track elements within forms
        return element.closest('form') !== null;
    }

    /**
     * Setup Livewire form watcher (if available)
     */
    setupFormWatcher() {
        // Check if Livewire is available
        if (typeof window.Livewire !== 'undefined') {
            // This will be handled by individual components
            console.log('📡 Livewire detected - form watching will be handled by component');
        }
    }

    /**
     * Schedule a save operation with debouncing
     */
    scheduleSave() {
        clearTimeout(this.saveTimeout);
        this.saveTimeout = setTimeout(() => {
            this.saveDraft();
        }, this.options.saveDelay);
    }

    /**
     * Save current form data to localStorage
     */
    saveDraft(data = null) {
        try {
            let formData = data;

            if (!formData) {
                formData = this.collectFormData();
            }

            if (this.hasMeaningfulData(formData)) {
                const draftWithMetadata = {
                    ...formData,
                    _metadata: {
                        savedAt: new Date().toISOString(),
                        userAgent: navigator.userAgent,
                        url: window.location.href
                    }
                };

                localStorage.setItem(this.options.draftKey, JSON.stringify(draftWithMetadata));
                this.draftData = draftWithMetadata;

                console.log('💾 Draft saved:', this.options.draftKey, draftWithMetadata);
                this.emit('draftSaved', draftWithMetadata);

                if (this.options.enableNotifications) {
                    this.showSaveIndicator();
                }
            }
        } catch (error) {
            console.error('❌ Error saving draft:', error);
            this.emit('saveError', error);
        }
    }

    /**
     * Collect form data from all forms on the page
     */
    collectFormData() {
        const forms = document.querySelectorAll('form');
        const allData = {};

        forms.forEach(form => {
            const formData = new FormData(form);

            for (let [key, value] of formData.entries()) {
                if (!this.options.excludeFields.includes(key)) {
                    if (this.options.includeFiles || !(value instanceof File)) {
                        allData[key] = value;
                    }
                }
            }
        });

        return allData;
    }

    /**
     * Check if data has meaningful content
     */
    hasMeaningfulData(data) {
        if (!data || typeof data !== 'object') return false;

        const meaningfulKeys = Object.keys(data).filter(key =>
            !key.startsWith('_') &&
            !this.options.excludeFields.includes(key) &&
            data[key] !== null &&
            data[key] !== undefined &&
            data[key] !== ''
        );

        return meaningfulKeys.length > 0;
    }

    /**
     * Show save indicator
     */
    showSaveIndicator() {
        // Remove existing indicator
        const existing = document.getElementById('draft-save-indicator');
        if (existing) existing.remove();

        // Create new indicator
        const indicator = document.createElement('div');
        indicator.id = 'draft-save-indicator';
        indicator.className = 'fixed bottom-4 right-4 z-50';
        indicator.innerHTML = `
            <div class="bg-green-50 border border-green-200 rounded-lg p-3 shadow-lg flex items-center space-x-2">
                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span class="text-sm text-green-800">Draft saved</span>
            </div>
        `;

        document.body.appendChild(indicator);

        // Auto-hide after 2 seconds
        setTimeout(() => {
            if (indicator.parentNode) {
                indicator.remove();
            }
        }, 2000);
    }

    /**
     * Restore draft data
     */
    restoreDraft() {
        if (!this.draftData) return false;

        try {
            console.log('📂 Restoring draft:', this.draftData);

            // Populate form fields
            Object.keys(this.draftData).forEach(key => {
                if (!key.startsWith('_') && !this.options.excludeFields.includes(key)) {
                    const element = document.querySelector(`[name="${key}"]`);
                    if (element && this.draftData[key] !== null && this.draftData[key] !== undefined) {
                        element.value = this.draftData[key];
                    }
                }
            });

            this.emit('draftRestored', this.draftData);
            console.log('✅ Draft restored successfully');

            return true;
        } catch (error) {
            console.error('❌ Error restoring draft:', error);
            this.emit('restoreError', error);
            return false;
        }
    }

    /**
     * Clear draft data
     */
    clearDraft() {
        localStorage.removeItem(this.options.draftKey);
        this.draftData = null;
        console.log('🗑️ Draft cleared:', this.options.draftKey);
        this.emit('draftCleared', { draftKey: this.options.draftKey });
    }

    /**
     * Get draft data
     */
    getDraft() {
        return this.draftData;
    }

    /**
     * Check if draft exists
     */
    hasDraft() {
        return this.hasValidDraft();
    }

    /**
     * Export draft data
     */
    exportDraft() {
        if (!this.draftData) return null;

        const exportData = {
            draftKey: this.options.draftKey,
            data: this.draftData,
            exportedAt: new Date().toISOString(),
            version: '1.0.0'
        };

        const blob = new Blob([JSON.stringify(exportData, null, 2)], {
            type: 'application/json'
        });

        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = `draft-${this.options.draftKey}-${new Date().toISOString().slice(0, 10)}.json`;
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        URL.revokeObjectURL(url);

        return exportData;
    }

    /**
     * Import draft data
     */
    importDraft(jsonData) {
        try {
            const data = typeof jsonData === 'string' ? JSON.parse(jsonData) : jsonData;

            if (data && data.data) {
                this.saveDraft(data.data);
                console.log('📥 Draft imported successfully');
                return true;
            }
        } catch (error) {
            console.error('❌ Error importing draft:', error);
        }
        return false;
    }

    /**
     * Event system for extensibility
     */
    on(event, callback) {
        if (!this.eventListeners[event]) {
            this.eventListeners[event] = [];
        }
        this.eventListeners[event].push(callback);
    }

    emit(event, data) {
        if (this.eventListeners[event]) {
            this.eventListeners[event].forEach(callback => {
                try {
                    callback(data);
                } catch (error) {
                    console.error(`Error in ${event} callback:`, error);
                }
            });
        }
    }

    /**
     * Destroy the auto-save system
     */
    destroy() {
        clearTimeout(this.saveTimeout);
        this.eventListeners = [];
        this.isInitialized = false;
        console.log('🗑️ Auto-Save Draft System destroyed');
    }
}

// Export for global use
window.AutoSaveDraft = AutoSaveDraft;

// Auto-initialize if data attribute is present
document.addEventListener('DOMContentLoaded', function() {
    const autoSaveElements = document.querySelectorAll('[data-auto-save-draft]');

    autoSaveElements.forEach(element => {
        const options = element.dataset.autoSaveDraft;
        try {
            const parsedOptions = options ? JSON.parse(options) : {};
            new AutoSaveDraft(parsedOptions);
        } catch (error) {
            console.error('Error initializing auto-save draft:', error);
        }
    });
});

console.log('📝 Auto-Save Draft System loaded successfully');