<div>
    <x-filament-actions::modals />

    <!-- Modal Trigger -->
    <x-filament::modal width="2xl" slide-over :close-by-clicking-away="false">
        <x-slot name="trigger">
            <x-filament::button>
                Post New Announcement
            </x-filament::button>
        </x-slot>
        <div>
            <x-slot name="heading">
                Post New Announcement
            </x-slot>
            <!-- Draft Restore Section -->
            <div id="announcementDraftSection" class="hidden bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-2">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <div>
                            <p class="text-sm font-medium text-blue-800">Draft Found</p>
                            <p class="text-xs text-blue-600">You have unsaved announcement data</p>
                        </div>
                    </div>
                    <button type="button" id="restoreAnnouncementDraftBtn"
                        class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors duration-200">
                        Restore Draft
                    </button>
                </div>
            </div>

            <form wire:submit="create">
                {{ $this->form }}
                <br><br>
                <x-filament::button type="submit">
                    Post Announcement
                </x-filament::button>
            </form>

        </div>
    </x-filament::modal>
    <br> <br>
    <div>
        {{ $this->table }}
    </div>

    <script>
        // Announcement Draft Functionality
        document.addEventListener('DOMContentLoaded', function() {
            const restoreBtn = document.getElementById('restoreAnnouncementDraftBtn');
            const draftSection = document.getElementById('announcementDraftSection');

            if (restoreBtn) {
                restoreBtn.addEventListener('click', function() {
                    const saved = localStorage.getItem('announcementDraft');
                    if (saved) {
                        try {
                            const data = JSON.parse(saved);
                            console.log('📂 Restoring announcement draft:', data);

                            // Restore data using Livewire
                            for (let key in data) {
                                if (data[key] !== null && data[key] !== undefined) {
                                    $wire.set('data.' + key, data[key]);
                                }
                            }

                            // Hide draft section and clear draft
                            draftSection.classList.add('hidden');
                            localStorage.removeItem('announcementDraft');

                            console.log('✅ Announcement draft restored successfully');
                        } catch (error) {
                            console.error('❌ Error restoring announcement draft:', error);
                            alert('❌ Failed to restore draft. The saved data may be corrupted.');
                        }
                    }
                });
            }
        });
    </script>
</div>
