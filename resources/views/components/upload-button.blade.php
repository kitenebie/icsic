<!-- resources/views/components/upload-button.blade.php -->

<x-filament-actions::action
    class="btn btn-primary"
    wire:click="$emit('openUploadModal')"  <!-- Emit event to open the modal -->
>
    Upload File
</x-filament-actions::action>
