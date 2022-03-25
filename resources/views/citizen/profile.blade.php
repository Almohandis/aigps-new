<x-base-layout>
    <div class="mt-6">

        @if (session('message'))
            <div class="alert alert-danger">
                {{ session('message') }}
            </div>
        @endif

        <div class="mx-auto text-center mt-5" id="profile">
            <div class="inline-block bg-black bg-opacity-50 p-8 text-justify" style="background-color: white;/*! box-shadow: black; */box-shadow: 0 .5rem 1.5rem rgba(0,0,0,.1);margin-left: 22rem;border-radius: 25px;">
                <h2 class="text-2xl">Account Settings</h2>
                <form action="/profile/update" method="POST">
                    @csrf

                    <!-- Name -->
                    <div class="mt-4">
                        <x-label for="name" :value="__('Name')" />

                        <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="$user->name" required autofocus />
                    </div>

                    <!-- Email Address -->
                    <div class="mt-4">
                        <x-label for="email" :value="__('Email')" />

                        <x-input oninput="validateEmail(this)" id="email" class="block mt-1 w-full" type="email" name="email" :value="$user->email" required />

                        <script>
                            function validateEmail(input) {
                                if (isEmail(input.value)) {
                                    input.style.outline = "green solid thin";
                                } else {
                                    input.style.outline = "red solid thin";
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
                        <x-label for="password" :value="__('Password')" />

                        <x-input oninput="validatePassword(this)" id="password" class="block mt-1 w-full"
                                        type="password"
                                        name="password"
                                        required autocomplete="new-password" />

                        
                        <script>
                            function validatePassword(input) {
                                if (input.value.length >= 8) {
                                    input.style.outline = "green solid thin";
                                } else {
                                    input.style.outline = "red solid thin";
                                }
                            }
                        </script>
                    </div>

                    <!-- Confirm Password -->
                    <div class="mt-4">
                        <x-label for="password_confirmation" :value="__('Confirm Password')" />

                        <x-input oninput="validatePasswordConfirm(this)" id="password_confirmation" class="block mt-1 w-full"
                                        type="password"
                                        name="password_confirmation" required />

                        <script>
                            function validatePasswordConfirm(input) {
                                if (input.value.length >= 8 && input.value == document.getElementById('password').value) {
                                    input.style.outline = "green solid thin";
                                } else {
                                    input.style.outline = "red solid thin";
                                }
                            }
                        </script>
                    </div>

                    
                    <!-- Address -->
                    <div class="mt-4">
                        <x-label :value="__('Address')" />

                        <x-input class="block mt-1 w-full" type="text" name="address" :value="$user->address" required autofocus />
                    </div>

                    <!-- Telephone Number -->
                    <div class="mt-4">
                        <x-label :value="__('Telephone number')" />

                        <x-input class="block mt-1 w-full" type="text" name="telephone_number" :value="$user->telephone_number" required autofocus />
                    </div>

                    <!-- Country -->
                    <div class="mt-4">
                        <x-label :value="__('Country')" />

                        <select :value="$user->country" name="country" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            @foreach ($countries as $country)
                                <option value="{{ $country }}">{{ $country }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- City -->
                    <div class="mt-4">
                        <x-label :value="__('City')" />

                        <select name="city" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            @foreach ($cities as $city)
                                <option value="{{ $city }}">{{ $city }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Gender -->
                    <div class="mt-3">
                        <x-label :value="__('Gender')" />

                        <select name="gender" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>

                    <!-- Birthdate -->
                    <div class="mt-3">
                        <x-label :value="__('Birthdate')" />

                        <x-input class="block mt-1 w-full" type="date" name="birthdate" :value="$user->birthdate" required />
                    </div>

                    <br>
                    <input type="submit" style="display: block; width: 100%;" class="bg-blue-500 text-white text-medium px-3 py-2 mt-3 rounded-md shadow-sm hover:bg-blue-400" value="Update" />
                </form>
            </div>
        </div>

        <div class="hidden mx-auto text-center mt-5" id="passport">
            <div class="inline-block bg-black bg-opacity-50 p-8 text-justify"
            style="background-color: white;/*! box-shadow: black; */box-shadow: 0 .5rem 1.5rem rgba(0,0,0,.1);margin-left: 22rem;border-radius: 25px;">
                If you have a passport and want to request your <strong>medical passport</strong>, type in your
                passport number and click on the button below
                <form action="/medical-passport" method="POST">
                    @csrf
                    <input type="text" name="passport_number" style="margin-left: 15rem;margin-top: 2rem;">
                    <input type="submit" value="Request medical passport" class="req-btn">
                </form>
            </div>
        </div>

        <div class="page-menu">
            <input type="button" value="Account Settings" class="p-menu-btn" onclick="ChangeView('profile')">
            <hr style="margin-left: 2.5rem;border-top-width: 2px;width: 70%;">
            <input type="button" value="Medical Passport" class="p-menu-btn" onclick="ChangeView('passport')">
        </div>

        <script>
            function ChangeView(view) {
                document.getElementById('profile').classList.add('hidden');
                document.getElementById('passport').classList.add('hidden');
                document.getElementById(view).classList.remove('hidden');
            }
        </script>
</x-base-layout>
