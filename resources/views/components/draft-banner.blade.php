{{-- Draft Banner Component --}}
{{-- A simple inline banner for draft notifications --}}

@props([
    'draftKey' => 'formDraft',
    'title' => 'Draft Found',
    'description' => 'You have unsaved form data.',
    'restoreText' => 'Restore Draft',
    'dismissText' => 'Dismiss',
    'variant' => 'blue', // 'blue', 'green', 'yellow', 'red'
    'showIcon' => true,
    'class' => ''
])

@php
    $variantClasses = [
        'blue' => 'bg-blue-50 border-blue-200 text-blue-800',
        'green' => 'bg-green-50 border-green-200 text-green-800',
        'yellow' => 'bg-yellow-50 border-yellow-200 text-yellow-800',
        'red' => 'bg-red-50 border-red-200 text-red-800',
    ];

    $iconColors = [
        'blue' => 'text-blue-600',
        'green' => 'text-green-600',
        'yellow' => 'text-yellow-600',
        'red' => 'text-red-600',
    ];
@endphp

<div
    id="draft-banner-{{ $draftKey }}"
    class="hidden {{ $variantClasses[$variant] ?? 'bg-blue-50 border-blue-200 text-blue-800' }} border rounded-lg p-4 mb-4 {{ $class }}"
    x-data="{
        show: false,
        init() {
            this.checkForDraft();
        },
        checkForDraft() {
            const draft = localStorage.getItem('{{ $draftKey }}');
            if (draft) {
                try {
                    const data = JSON.parse(draft);
                    if (data && Object.keys(data).length > 0) {
                        this.show = true;
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
        }
    }"
    x-show="show"
    x-transition
    x-cloak
>
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-3">
            @if($showIcon)
            <svg class="w-5 h-5 flex-shrink-0 {{ $iconColors[$variant] ?? 'text-blue-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            @endif

            <div>
                <p class="text-sm font-medium">{{ $title }}</p>
                <p class="text-sm opacity-75">{{ $description }}</p>
            </div>
        </div>

        <div class="flex items-center space-x-2">
            <button
                @click="restoreDraft()"
                class="px-3 py-1.5 bg-blue-600 text-white text-sm font-medium rounded hover:bg-blue-700 transition-colors duration-200"
            >
                {{ $restoreText }}
            </button>
            <button
                @click="dismissDraft()"
                class="px-3 py-1.5 bg-gray-300 text-gray-700 text-sm font-medium rounded hover:bg-gray-400 transition-colors duration-200"
            >
                {{ $dismissText }}
            </button>
        </div>
    </div>
</div>