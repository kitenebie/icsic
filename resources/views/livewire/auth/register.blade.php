<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component {
    public string $FirstName = '';
    public string $LastName = '';
    public string $MiddleName = '';
    public string $extension_name = '';
    public string $contact = '';
    public string $email = '';
public function register(): void
{
    $validated = $this->validate([
        'FirstName'       => ['required', 'string', 'max:255'],
        'LastName'        => ['required', 'string', 'max:255'],
        'MiddleName'      => ['nullable', 'string', 'max:255'],
        'extension_name'  => ['nullable', 'string', 'max:255'],
        'contact'         => ['nullable','digits:11'], // enforces exactly 11 digits
        'email'           => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
        'password'        => ['required', 'confirmed', Rules\Password::defaults()],
    ]);

    // Hash password
    $validated['password'] = Hash::make($validated['password']);

    // Create user
    $user = User::create($validated);

    event(new Registered($user));

    // Log in the newly created user
    Auth::login($user);

    // Redirect to waiting page
    $this->redirect('/waiting');
}

}; ?>

<div class="flex flex-col gap-6">
    <x-auth-header :title="__('Create an account')" :description="__('Enter your details below to create your account')" />

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form class="flex flex-col gap-6" method="POST" action="{{ route('register') }}">
    @csrf
        <!-- First Name -->
        <flux:input
            name="FirstName"
            :label="__('First Name')"
            type="text"
            required
            autofocus
            autocomplete="FirstName"
            :placeholder="__('First name')"
        />
        <!-- Last Name -->
        <flux:input
            name="LastName"
            :label="__('Last Name')"
            type="text"
            required
            autocomplete="LastName"
            :placeholder="__('Last name')"
        />
        <!-- Last Name -->
        <flux:input
            name="MiddleName"
            :label="__('Middle Name')"
            type="text"
            autocomplete="MiddleName"
            :placeholder="__('Middle name')"
        />
        <!-- Ext Name -->
        <flux:input
            name="extension_name"
            :label="__('Ext Name')"
            type="text"
            autocomplete="extension_name"
            :placeholder="__('Ext name')"
        />
        <!-- conact -->
        <flux:input
            name="contact"
            :label="__('Contact Number')"
            type="number"
            autocomplete="contact"
            :placeholder="__('Contact Number')"
        />
        <!-- Email Address -->
        <flux:input
            name="email"
            :label="__('Email address')"
            type="email"
            required
            autocomplete="email"
            placeholder="email@example.com"
        />

        <div class="flex items-center justify-end">
            <flux:button type="submit" variant="primary" class="w-full">
                {{ __('Create account') }}
            </flux:button>
        </div>
    </form>

    <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-600 dark:text-zinc-400">
        {{ __('Already have an account?') }}
        <flux:link :href="route('login')" wire:navigate>{{ __('Log in') }}</flux:link>
    </div>
</div>
