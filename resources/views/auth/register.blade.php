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

        <form method="POST" action="{{ route('register') }}">
            @csrf
            <!-- National ID -->
            <div>
                <x-label for="national_id" value="National ID" />

                <x-input id="national_id" class="block mt-1 w-full" type="text" name="national_id" :value="old('national_id')" required autofocus />
            </div>

            <!-- Name -->
            <div class="mt-4">
                <x-label for="name" :value="__('Name')" />

                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-label for="email" :value="__('Email')" />

                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Password')" />

                <x-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="new-password" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-label for="password_confirmation" :value="__('Confirm Password')" />

                <x-input id="password_confirmation" class="block mt-1 w-full"
                                type="password"
                                name="password_confirmation" required />
            </div>

            
            <!-- Address -->
            <div class="mt-4">
                <x-label :value="__('Address')" />

                <x-input class="block mt-1 w-full" type="text" name="address" :value="old('address')" required autofocus />
            </div>

            <!-- Telephone Number -->
            <div class="mt-4">
                <x-label :value="__('Telephone number')" />

                <x-input class="block mt-1 w-full" type="text" name="telephone_number" :value="old('telephone_number')" required autofocus />
            </div>

            <!-- Country -->
            <div class="mt-4">
                <x-label :value="__('Country')" />

                <select name="country" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
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

                <x-input class="block mt-1 w-full" type="date" name="birthdate" :value="old('birthdate')" required />
            </div>

            <br>

            <!-- Phones -->
            <div id="phones">
                <input style="height: 2.5rem; border-radius: 5px; width: 100%;" placeholder="+20" class="block mt-1 p-3" type="number" name="phone1" required />
            </div>

            <div onclick="addPhone()"
                class="text-center bg-blue-500 text-white text-medium px-3 py-2 mt-3 rounded-md shadow-sm hover:bg-blue-400">
                Add Phone
            </div>

            <div id="removeAPhone" onclick="removePhone()"
                class="hidden text-center bg-black text-white text-medium px-3 py-2 mt-3 rounded-md shadow-sm">
                Remove Phone
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
                    phone.style.height= "2.5rem";
                    phone.style.borderRadius="5px";
                    phone.style.width="100%";

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

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-button class="ml-4">
                    {{ __('Register') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-auth-layout>
