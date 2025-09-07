<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component {

}; ?>

<div class="flex flex-col gap-6">
    <x-auth-header :title="__('Create an account')" :description="__('Enter your details below to create your account')" />

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form class="flex flex-col gap-6" method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
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

        <!-- Front ID -->
        <div>
            <label for="front_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Front ID</label>
            <input
                type="file"
                name="front_id"
                id="front_id"
                accept="image/*"
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
            />
        </div>

        <!-- Back ID -->
        <div>
            <label for="back_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Back ID</label>
            <input
                type="file"
                name="back_id"
                id="back_id"
                accept="image/*"
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
            />
        </div>

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
