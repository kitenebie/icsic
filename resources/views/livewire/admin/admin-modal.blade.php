<div>
    
    <flux:modal :dismissible="false" class="w-1/2" wire:model.self="showAdminModal">
            <flux:heading size="xl">Welcome Admin</flux:heading>
            <flux:text class="mt-2">Do you want to redirect to your dashboard?</flux:text>
            <br><hr><br>
            <div class="flex mt-4">
                <flux:button type="button" wire:click='dashboardDirect' variant="primary">Yes! Go to Dashboard</flux:button>
                <flux:spacer />
            </div>
    </flux:modal>
</div>
