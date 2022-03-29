<x-auth-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <div class="text-2xl font-bold text-center mb-4">
            AIGPS
        </div>

        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" rel="stylesheet">
        <script>
            var errors = {
                national_id: '',
                password: ''
            };

            function updateError() {
                for(var key in errors) {
                    if (errors[key] == '#') {
                        document.getElementById(key + '_mark').style.display = 'inline-block';
                        document.getElementById(key + '_mark').classList.add('fa-check');
                        document.getElementById(key + '_mark').classList.remove('fa-close');
                        document.getElementById(key + '_error').innerHTML = '';
                        document.getElementById(key + '_mark').style.color = 'green';
                        document.getElementById('submitBtn').disabled = false;
                    }
                    else if (errors[key] != '') {
                        document.getElementById(key + '_mark').style.color = 'red';
                        document.getElementById(key + '_mark').classList.add('fa-close');
                        document.getElementById(key + '_mark').classList.remove('fa-check');
                        document.getElementById(key + '_mark').style.display = 'inline-block';
                        document.getElementById(key + '_error').innerHTML = errors[key];
                        document.getElementById('submitBtn').disabled = true;
                    } else {
                        document.getElementById(key + '_error').innerHTML = '';
                        document.getElementById(key + '_mark').style.display = 'none';
                    }
                }
            }
        </script>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- National ID -->
            <div>
                <i  id="national_id_mark" class="fa-solid fa-close" style="display: inline-block; color: red;"></i>
                
                <x-label style="display: inline-block;" for="national_id" value="National ID" />

                <x-input id="national_id" class="block mt-1 w-full" type="text" name="national_id" :value="old('national_id')" oninput="validateNid(this)"  required autofocus />
                <small class="text-red-500" id="national_id_error"></small>
                <script>
                    function validateNid(input) {
                        if (input.value.length != 14 || isNaN(input.value) || !(input.value[0] == '2' || input.value[0] == '1' || input.value[0] == '3')) {
                            input.style.outline = "red solid thin";
                            errors.national_id = 'National Id error [National Id must be 14 digits and start with 2, 1 or 3]';
                        } else {
                            input.style.outline = "green solid thin";
                            errors.national_id = '#';
                        }
                        updateError();
                    }
                </script>
            </div>

            <!-- Password -->
            <div class="mt-4">
                <i  id="password_mark" class="fa-solid fa-close" style="display: inline-block; color: red;"></i>
                <x-label style="display: inline-block;" for="password" :value="__('Password')" />

                <x-input oninput="validatePassword(this)" id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
                <small class="text-red-500" id="password_error"></small>
                <script>
                    function validatePassword(input) {
                        if (input.value.length >= 8 && containsUpperCase(input.value) && containsLowerCase(input.value) && containsNumber(input.value)) {
                            input.style.outline = "green solid thin";
                            errors.password = '#';
                        } else {
                            input.style.outline = "red solid thin";
                            errors.password = 'Password error [Password must be at least 8 characters]';
                        }

                        updateError();
                    }

                    function containsUpperCase(str) {
                        return /[A-Z]/.test(str);
                    }

                    function containsLowerCase(str) {
                        return /[a-z]/.test(str);
                    }

                    function containsNumber(str) {
                        return /[0-9]/.test(str);
                    }
                </script>
            </div>

            <!-- Remember Me -->
            <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" name="remember">
                    <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="mt-4">
                <div class="container">
                    @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                    @endif
                </div>

                <div class="mt-3 mx-auto text-center">
                    <x-button id="submitBtn">
                        {{ __('Log in') }}
                    </x-button>
                </div>
            </div>
        </form>
    </x-auth-card>
</x-auth-layout>
