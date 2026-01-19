<?php

use App\Models\Organization; // FIX: Added this
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB; // Ensure this is here
use Illuminate\Support\Str;        // Ensure this is here
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $business_name = '';
    public string $first_name = '';
    public string $last_name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Handle an incoming registration request.
     */


    public function register()
{
    $validated = $this->validate([
        'first_name' => ['required', 'string', 'max:255'],
        'last_name' => ['required', 'string', 'max:255'],
        'business_name' => ['required', 'string', 'max:255', 'unique:organizations,name'],
        'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
        'password' => ['required', 'string', 'confirmed', \Illuminate\Validation\Rules\Password::defaults()],
    ]);

    // DB Transaction ensures if User fails, Org isn't left hanging
    \Illuminate\Support\Facades\DB::transaction(function () use ($validated) {
        $organization = \App\Models\Organization::create([
            'name' => $this->business_name,
            'slug' => \Illuminate\Support\Str::slug($this->business_name),
        ]);

        $user = \App\Models\User::create([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'password' => \Illuminate\Support\Facades\Hash::make($this->password),
            'organization_id' => $organization->id,
        ]);

        // Re-enable Role Assignment
        $user->assignRole('Org Admin');

        \Illuminate\Support\Facades\Auth::login($user);
    });

    return redirect()->intended(route('dashboard', absolute: false));
}
}; ?>

<div>
    <form wire:submit="register">

        <!-- Business Name -->
        <div class="mt-4">
            <x-input-label for="business_name" :value="__('Business Name')" />
            <x-text-input wire:model="business_name" id="business_name" class="block mt-1 w-full" type="text" name="business_name" required autofocus />
            <x-input-error :messages="$errors->get('business_name')" class="mt-2" />
        </div>


        <!-- First Name -->
        <div>
            <x-input-label for="first_name" :value="__('First Name')" />
            <x-text-input wire:model="first_name" id="first_name" class="block mt-1 w-full" type="text" name="first_name" required autofocus autocomplete="first_name" />
            <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
        </div>

        <!-- Last Name -->
        <div>
            <x-input-label for="last_name" :value="__('Last Name')" />
            <x-text-input wire:model="last_name" id="last_name" class="block mt-1 w-full" type="text" name="last_name" required autofocus autocomplete="last_name" />
            <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input wire:model="email" id="email" class="block mt-1 w-full" type="email" name="email" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input wire:model="password" id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input wire:model="password_confirmation" id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}" wire:navigate>
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</div>
