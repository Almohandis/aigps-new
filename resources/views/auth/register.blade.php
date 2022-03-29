<x-auth-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <div class="text-2xl font-bold text-center mb-4">
            AIGPS
        </div>
        <style>
            .:hover{
                background-color:  #18375d;
            }
        </style>

        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" rel="stylesheet">
        <script>
            var errors = {
                national_id: '',
                email: '',
                password: '',
                password_confirmation: '',
                workemail: '',
            };

            function updateError() {
                for (var key in errors) {
                    if (errors[key] == '#') {
                        document.getElementById(key + '_mark').style.display = 'inline-block';
                        document.getElementById(key + '_mark').classList.add('fa-check');
                        document.getElementById(key + '_mark').classList.remove('fa-close');
                        document.getElementById(key + '_error').innerHTML = '';
                        document.getElementById(key + '_mark').style.color = 'green';

                    } else if (errors[key] != '') {
                        document.getElementById(key + '_mark').style.color = 'red';
                        document.getElementById(key + '_mark').classList.add('fa-close');
                        document.getElementById(key + '_mark').classList.remove('fa-check');
                        document.getElementById(key + '_mark').style.display = 'inline-block';
                        document.getElementById(key + '_error').innerHTML = errors[key];
                    } else {
                        document.getElementById(key + '_error').innerHTML = '';
                        document.getElementById(key + '_mark').style.display = 'none';
                    }
                }
            }
        </script>

        <form method="POST" action="{{ route('register') }}" class="mt-4" style="margin-bottom: 2rem;">
            @csrf
            <div style="display: inline-block;margin-left: 8%;">
                <!-- National ID -->
                <div>

                    <x-label for="national_id" value="National ID *" style="display: inline-block;" />
                    <i id="national_id_mark" class="fa-solid fa-close" style="display: inline-block; color: red;"></i>
                    <x-input id="national_id" class="block mt-1 w-full" type="text" name="national_id"
                        :value="old('national_id')" oninput="validateNid(this)" style="width: 20rem;" required
                        autofocus />
                    <small class="text-red-500" id="national_id_error"></small>
                    <script>
                        function validateNid(input) {
                            if (input.value.length != 14 || isNaN(input.value) || !(input.value[0] == '2' || input.value[0] == '1' || input
                                    .value[0] == '3')) {
                                input.style.outline = "red solid thin";
                                errors.national_id =
                                    'National ID is invalid [National Id must be 14 characters long, and starts with 1,2,3]';
                                updateError();
                            } else {
                                input.style.outline = "green solid thin";
                                errors.national_id = '#';
                                updateError();
                            }
                        }
                    </script>
                </div>

                <!-- Name -->
                <div class="mt-4">
                    <x-label for="name" :value="__('Name *')" />

                    <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')"
                        style="width: 20rem;" required autofocus />
                </div>

                <!-- Email Address -->
                <div class="mt-4">

                    <x-label for="email" :value="__('Email *')" style="display: inline-block;" />
                    <i id="email_mark" class="fa-solid fa-close" style="display: inline-block; color: red;"></i>

                    <x-input oninput="validateEmail(this)" id="email" class="block mt-1 w-full" style="width: 20rem;"
                        type="email" name="email" :value="old('email')" required />
                    <small class="text-red-500" id="email_error"></small>
                    <script>
                        function validateEmail(input) {
                            if (isEmail(input.value)) {
                                input.style.outline = "green solid thin";
                                errors.email = '#';
                                updateError();
                            } else {
                                input.style.outline = "red solid thin";
                                errors.email = 'Email is invalid [e.g test@domain.com]';
                                updateError();
                            }
                        }

                        function isEmail(email) {
                            return email.match(
                                /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
                            );
                        };
                    </script>
                </div>

                <!-- Password -->
                <div class="mt-4">

                    <x-label for="password" :value="__('Password *')" style="display: inline-block;" />
                    <i id="password_mark" class="fa-solid fa-close" style="display: inline-block; color: red;"></i>

                    <x-input oninput="validatePassword(this)" id="password" class="block mt-1 w-full" type="password"
                        style="width: 20rem;" name="password" required autocomplete="new-password" />

                    <small class="text-red-500" id="password_error"></small>
                    <script>
                        function validatePassword(input) {
                            if (input.value.length >= 8 && containsUpperCase(input.value) && containsLowerCase(input.value) &&
                                containsNumber(input.value)) {
                                input.style.outline = "green solid thin";
                                errors.password = '#';
                                updateError();
                            } else {
                                input.style.outline = "red solid thin";
                                errors.password = 'Password must be at least 8 characters and contain at least one uppercase character';
                                updateError();
                            }
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

                <!-- Confirm Password -->
                <div class="mt-4">

                    <x-label for="password_confirmation" :value="__('Confirm Password *')"
                        style="display: inline-block;" />
                    <i id="password_confirmation_mark" class="fa-solid fa-close"
                        style="display: inline-block; color: red;"></i>

                    <x-input oninput="validatePasswordConfirm(this)" id="password_confirmation"
                        class="block mt-1 w-full" style="width: 20rem;" type="password" name="password_confirmation"
                        required />
                    <small class="text-red-500" id="password_confirmation_error"></small>

                    <script>
                        function validatePasswordConfirm(input) {
                            if (input.value.length >= 8 && input.value == document.getElementById('password').value) {
                                input.style.outline = "green solid thin";
                                errors.password_confirmation = '#';
                                updateError();
                            } else {
                                input.style.outline = "red solid thin";
                                errors.password_confirmation = 'Password confirmation must be at least 8 characters and match password';
                                updateError();
                            }
                        }
                    </script>
                </div>


                <!-- Address -->
                <div class="mt-4">
                    <x-label :value="__('Address *')" />

                    <x-input style="width: 20rem;" class="block mt-1 w-full" type="text" name="address"
                        :value="old('address')" required autofocus />
                </div>

                <!-- Telephone Number -->
                <div class="mt-4">
                    <x-label :value="__('Telephone number *')" />

                    <x-input style="width: 20rem;" class="block mt-1 w-full" type="text" name="telephone_number"
                        :value="old('telephone_number')" required autofocus />
                </div>
            </div>
            <div style="margin-left: 66%;margin-top: -47.3%;">
                <!-- Country -->
                <div class="mt-4">
                    <x-label :value="__('Country *')" />

                    <select style="width: 20rem;" name="country"
                        class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        @foreach ($countries as $country)
                            <option value="{{ $country }}">{{ $country }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- City -->
                <div class="mt-4">
                    <x-label :value="__('City *')" />

                    <select style="width: 20rem;" name="city"
                        class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        @foreach ($cities as $city)
                            <option value="{{ $city }}">{{ $city }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Gender -->
                <div class="mt-3">
                    <x-label :value="__('Gender *')" />

                    <select style="width: 20rem;" name="gender"
                        class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>

                <!-- Birthdate -->
                <div class="mt-3">
                    <x-label :value="__('Birthdate *')" />

                    <x-input style="width: 13rem;height: 2.5rem;text-align: center;" class="block mt-1 w-full"
                        type="date" name="birthdate" :value="old('birthdate')" required />
                </div>

                <br>


                <!-- Work Address -->
                <div class="mt-2 mb-4">
                    <x-label for="workemail" value="Work Email (optional)" style="display: inline-block;" />
                    <i id="workemail_mark" class="fa-solid fa-close" style="display: inline-block; color: red;"></i>

                    <x-input oninput="validateWorkEmail(this)" id="workemail" style="width: 20rem;"
                        class="block mt-1 w-full" type="email" name="workemail" :value="old('workemail')" />
                    <small class="text-red-500" id="workemail_error"></small>

                    <script>
                        function validateWorkEmail(input) {
                            if (isEmail(input.value)) {
                                input.style.outline = "green solid thin";
                                errors.workemail = '#';
                                updateError();
                            } else {
                                input.style.outline = "red solid thin";
                                errors.workemail = 'Work Email is invalid [e.g test@domain.com]';
                                updateError();
                            }
                        }
                    </script>
                </div>

                <!-- Phones -->
                <div id="phones">
                    <x-label :value="__('Mobile  Number *')" />
                    <input style="height: 2.5rem; border-radius: 5px; width: 20rem;" placeholder="+20"
                        class="block mt-1 p-3" type="number" name="phone1" required />
                </div>

                <div onclick="addPhone()" style="width: 10rem;background-color: #3b82f6;"
                    class="text-center bg-blue-500 text-white text-medium px-3 py-2 mt-3 rounded-md shadow-sm hover:bg-blue-400">
                    Add Phone
                </div>

                <div id="removeAPhone" onclick="removePhone()" style="width: 10rem;"
                    class="hidden text-center bg-black text-white text-medium px-3 py-2 mt-3 rounded-md shadow-sm">
                    Remove Phone
                </div>
            </div>
            <script>
                var phones = 2;
                var phone_input = document.getElementById('phones');

                function addPhone() {
                    var phone = document.createElement('input');
                    phone.setAttribute('type', 'number');
                    phone.setAttribute('name', 'phone' + phones);
                    phone.setAttribute('placeholder', '+20');
                    phone.setAttribute('required', '');
                    phone.setAttribute('class', 'block mt-1');
                    phone.style.height = "2.5rem";
                    phone.style.borderRadius = "5px";
                    phone.style.width = "20rem";

                    phone_input.appendChild(phone);

                    phones++;

                    if (phones > 2) {
                        document.getElementById('removeAPhone').classList.remove('hidden');
                    }
                }

                function removePhone() {
                    if (phones > 2) {
                        phone_input.removeChild(phone_input.lastChild);
                        phones--;

                        if (phones == 2) {
                            document.getElementById('removeAPhone').classList.add('hidden');
                        }
                    }
                }
            </script>

            <script>
                for (var key in errors) {
                    document.getElementById(key + '_mark').style.display = 'none';
                }
            </script>

            <div class="flex items-center justify-end mt-4" style="margin-top: 5rem;">
                <a class="ml-4" href="/"
                    style="border-radius: 5px; border: 1px solid gray; padding: 4px 10px;background-color: crimson;color: white;margin-right: 41.5rem;width: 7rem;text-align: center;font-size: 14px;">
                    {{ __('CANCEL') }}
                </a>
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-button class="ml-4" style="margin-right: 6rem;">
                    {{ __('Register') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-auth-layout>
