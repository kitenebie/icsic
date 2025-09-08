{{-- Draft Notification Component --}}
{{-- A reusable component for displaying draft notifications and restore functionality --}}

@props([
    'draftKey' => 'formDraft',
    'title' => 'Draft Found',
    'description' => 'You have unsaved form data from a previous session.',
    'restoreText' => 'Restore Draft',
    'dismissText' => 'Dismiss',
    'closeText' => 'Close',
    'showIcon' => true,
    'position' => 'top-right',
    'autoHide' => true,
    'autoHideDelay' => 10000,
    'variant' => 'default', // 'default', 'success', 'warning', 'error'
    'size' => 'md', // 'sm', 'md', 'lg'
])

@php
    $positionClasses = [
        'top-left' => 'top-4 left-4',
        'top-right' => 'top-4 right-4',
        'bottom-left' => 'bottom-4 left-4',
        'bottom-right' => 'bottom-4 right-4',
        'top-center' => 'top-4 left-1/2 transform -translate-x-1/2',
        'bottom-center' => 'bottom-4 left-1/2 transform -translate-x-1/2',
    ];

    $variantClasses = [
        'default' => 'bg-blue-50 border-blue-200 text-blue-800',
        'success' => 'bg-green-50 border-green-200 text-green-800',
        'warning' => 'bg-yellow-50 border-yellow-200 text-yellow-800',
        'error' => 'bg-red-50 border-red-200 text-red-800',
    ];

    $sizeClasses = [
        'sm' => 'p-3 text-sm',
        'md' => 'p-4 text-sm',
        'lg' => 'p-6 text-base',
    ];

    $iconColors = [
        'default' => 'text-blue-600',
        'success' => 'text-green-600',
        'warning' => 'text-yellow-600',
        'error' => 'text-red-600',
    ];
@endphp

<div
    id="draft-notification-{{ $draftKey }}"
    class="fixed {{ $positionClasses[$position] ?? 'top-4 right-4' }} z-50 max-w-sm animate-fade-in"
    x-data="{
        show: false,
        autoHideTimer: null,
        init() {
            // Check for draft on initialization
            this.checkForDraft();
        },
        checkForDraft() {
            const draft = localStorage.getItem('{{ $draftKey }}');
            if (draft) {
                try {
                    const data = JSON.parse(draft);
                    if (data && Object.keys(data).length > 0) {
                        this.show = true;
                        @if($autoHide)
                        this.autoHideTimer = setTimeout(() => {
                            this.show = false;
                        }, {{ $autoHideDelay }});
                        @endif
                    }
                } catch (error) {
                    console.error('Error parsing draft data:', error);
                }
            }
        },
        restoreDraft() {
            const draft = localStorage.getItem('{{ $draftKey }}');
            if (draft) {
                try {
                    const data = JSON.parse(draft);
                    // Emit custom event for parent component to handle restoration
                    this.$dispatch('draft-restore', { draftKey: '{{ $draftKey }}', data: data });
                    this.show = false;
                    localStorage.removeItem('{{ $draftKey }}');
                    console.log('✅ Draft restored successfully');
                } catch (error) {
                    console.error('❌ Error restoring draft:', error);
                    alert('❌ Failed to restore draft. The saved data may be corrupted.');
                }
            }
        },
        dismissDraft() {
            this.show = false;
            localStorage.removeItem('{{ $draftKey }}');
            console.log('🗑️ Draft dismissed');
        },
        closeNotification() {
            this.show = false;
            if (this.autoHideTimer) {
                clearTimeout(this.autoHideTimer);
            }
        }
    }"
    x-show="show"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 transform scale-95"
    x-transition:enter-end="opacity-100 transform scale-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100 transform scale-100"
    x-transition:leave-end="opacity-0 transform scale-95"
    x-cloak
>
    <div class="bg-white border rounded-lg shadow-lg overflow-hidden {{ $sizeClasses[$size] ?? 'p-4' }}">
        <div class="flex items-start">
            @if($showIcon)
            <div class="flex-shrink-0">
                <svg class="w-5 h-5 {{ $iconColors[$variant] ?? 'text-blue-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </div>
            @endif

            <div class="ml-3 w-0 flex-1">
                <p class="font-medium {{ $variantClasses[$variant] ?? 'text-blue-800' }}">
                    {{ $title }}
                </p>
                <p class="mt-1 {{ $variantClasses[$variant] ?? 'text-blue-600' }} opacity-75">
                    {{ $description }}
                </p>

                <div class="mt-3 flex space-x-2">
                    <button
                        @click="restoreDraft()"
                        class="px-3 py-1.5 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors duration-200"
                    >
                        {{ $restoreText }}
                    </button>
                    <button
                        @click="dismissDraft()"
                        class="px-3 py-1.5 bg-gray-300 text-gray-700 text-sm font-medium rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors duration-200"
                    >
                        {{ $dismissText }}
                    </button>
                </div>
            </div>

            <div class="ml-4 flex-shrink-0 flex">
                <button
                    @click="closeNotification()"
                    class="inline-flex {{ $variantClasses[$variant] ?? 'text-blue-400' }} hover:text-gray-600 focus:outline-none"
                    title="{{ $closeText }}"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Draft Save Indicator --}}
<div
    id="draft-save-indicator-{{ $draftKey }}"
    class="fixed bottom-4 right-4 z-50 animate-fade-in"
    x-data="{ show: false }"
    x-show="show"
    x-transition
    x-cloak
    style="display: none;"
>
    <div class="bg-green-50 border border-green-200 rounded-lg p-3 shadow-lg flex items-center space-x-2">
        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
        </svg>
        <span class="text-sm text-green-800">Draft saved</span>
    </div>
</div>

{{-- Inline Scripts for Draft Management --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Listen for draft save events
    window.addEventListener('draft-saved', function(e) {
        if (e.detail && e.detail.draftKey === '{{ $draftKey }}') {
            showSaveIndicator();
        }
    });

    function showSaveIndicator() {
        const indicator = document.getElementById('draft-save-indicator-{{ $draftKey }}');
        if (indicator) {
            // Show indicator
            indicator.style.display = 'block';
            indicator._x_data.show = true;

            // Auto-hide after 2 seconds
            setTimeout(() => {
                if (indicator._x_data) {
                    indicator._x_data.show = false;
                    setTimeout(() => {
                        indicator.style.display = 'none';
                    }, 200); // Wait for transition
                }
            }, 2000);
        }
    }
});
</script>

{{-- Custom CSS for animations --}}
<style>
@keyframes fade-in {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}

.animate-fade-in {
    animation: fade-in 0.3s ease-out;
}

/* Ensure proper stacking context */
#draft-notification-{{ $draftKey }} {
    z-index: 9999;
}

#draft-save-indicator-{{ $draftKey }} {
    z-index: 9998;
}
</style>