<x-app-layout>
    

    <div class="flex container justify-content-center">
        <div class="text-start shadow container bg-white mt-5 rounded px-3 py-3 text-dark row justify-content-center">
            <x-auth-card>
                <x-slot name="logo">
                    <div  class="text-center mb-4">
                        <a href="/">
                            <x-application-logo />
                        </a>
                    </div>
                </x-slot>

                <div class="mb-4 text-sm text-gray-600">
                    {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
                </div>

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <!-- Validation Errors -->
                <x-auth-validation-errors class="mb-4" :errors="$errors" />

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <!-- Email Address -->
                    <div>
                        <x-label for="email" :value="__('Email')" />

                        <x-input id="email" class="block mt-1 w-full form-control" type="email" name="email" :value="old('email')" required autofocus />
                    </div>

                    <div class="text-center my-4">
                        <button class="btn btn-success">
                            {{ __('Email Password Reset Link') }}
                        </button>
                    </div>
                </form>
            </x-auth-card>
        </div>
    </div>
</x-app-layout>
