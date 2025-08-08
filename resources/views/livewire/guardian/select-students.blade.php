<div>
    <flux:modal :dismissible="false" class="w-1/2" wire:model.self="showConfirmModal">
            <flux:heading size="xl">Complete Your Verification</flux:heading>
            <flux:text class="mt-2">To ensure the security and integrity of your account, we require a few additional details to verify your identity. Please fill out the information requested below. Once submitted, our system will review your data, and your account will be fully verified.</flux:text>
            <br><hr><br>
            <flux:heading size="xl">Why Do We Need This Information?</flux:heading>
            <flux:text class="mt-2">This information is necessary to comply with industry regulations and to protect both you and our platform from unauthorized access and fraudulent activity. Completing your verification helps us confirm your identity and ensures a secure experience for all users.</flux:text>
            <br><hr><br>
            <flux:heading size="xl">Steps to Complete Your Account Verification:</flux:heading>
            <flux:text class="mt-2"><b>1. Personal Information:</b> We’ll need details like your full name and an active email address to verify your identity.</flux:text>
            <flux:text class="mt-2"><b>2. Guardianship Details:</b> Applicable, please provide information regarding any children you are a legal guardian for.</flux:text>
            <br>
            <flux:text class="mt-2">Once all required information is submitted, we’ll review it and notify you when your account is fully verified. This may take a few moments, so please be patient.</flux:text>
            <br>
            <flux:text class="mt-2">By completing this process, you’re ensuring a safer, more secure experience on our platform. Thank you for your cooperation!</flux:text>
            <div class="flex mt-4">
                <flux:button type="button" wire:click='verify' variant="primary">Verify Account</flux:button>
                <flux:spacer />
                <flux:button class="ml-4" type="button" wire:click='limited' variant="danger">Limited Access</flux:button>
            </div>
    </flux:modal>
    <flux:modal :dismissible="false" class="w-full" wire:model.self="showVerificationFormModal"> 
        <flux:heading size="xl">Personal Information</flux:heading>    
        <flux:field>
            <flux:label>First Name</flux:label>
            <flux:input value="{{ Illuminate\Support\Facades\Auth::user()->FirstName }}" />
        </flux:field>
        <br>
        <flux:field>
            <flux:label>Middle Name</flux:label>
            <flux:input value="{{ Illuminate\Support\Facades\Auth::user()->MiddleName }}" />
        </flux:field>
        <br>
        <flux:field>
            <flux:label>Last Name</flux:label>
            <flux:input value="{{ Illuminate\Support\Facades\Auth::user()->LastName }}" />
        </flux:field>
        <br>
        <flux:field>
            <flux:label>Address</flux:label>
            <flux:input />
        </flux:field>
        <br>
        <flux:separator />
        <br>
        <flux:heading size="xl">Guardianship Details</flux:heading>
        <flux:field>
            <flux:label>Search</flux:label>
            <flux:description>Search your student</flux:description>
            <flux:input />
            <flux:error name="Search" />
        </flux:field>
        <br>
        <flux:separator />
        <br>
        <flux:checkbox.group wire:model="students" label="result">
            <flux:checkbox label="Anna Crush" value="1" />
            <flux:checkbox label="Aljon Balye" value="2" />
            <flux:checkbox label="Cyruz De Palma" value="3" />
            <flux:checkbox label="Aiza Dela Rosa" value="4" />
        </flux:checkbox.group>
        <div class="flex mt-4">
            <flux:button type="button" wire:click='submit' variant="primary">Submit</flux:button>
            <flux:spacer />
            <flux:button class="ml-4" type="button" wire:click='limited' variant="danger">Limited Access</flux:button>
        </div>
    </flux:modal>

</div>
