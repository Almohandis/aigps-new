<x-base-layout>
    <div class="mt-6">
        <h1 class="ml-5 text-left text-4xl text-white" style="text-shadow: 2px 2px 8px #000000;">
            Vaccination Reserve
        </h1>
        
        <div class="mx-auto text-center mt-2">
            <p class="inline-block text-center text-xl bg-blue-500 font-bold rounded-full text-white w-8 h-8 pt-1">1</p>
            <div class="inline-block mx-3 bg-black w-10 h-1 mb-1 bg-opacity-50"></div>
            <p class="inline-block text-center text-xl bg-white font-bold rounded-full text-blue-500 w-8 h-8 pt-1">2</p>
        </div>

        <div class="mx-auto text-center mt-5">
            
            <form class="inline-block bg-black bg-opacity-50 p-8 text-justify" method="POST" action="/reserve">
                @if ($errors->any())
                    <div>
                        <div class="font-medium text-red-600">
                            {{ __('Whoops! Something went wrong.') }}
                        </div>

                        <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            
                @csrf
                <div>
                    <x-label for="address" value="Adress" class="text-white" />

                    <x-input id="address" class="block mt-1 w-full" type="text" name="address" :value="old('address')" required autofocus />
                </div>

                <div>
                    <x-label for="country" value="country" class="text-white" />

                    <select name="country" id="country" class="block mt-1 w-full">
                        @foreach($countries as $country)
                            <option value="{{ $country }}">{{ $country }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mt-3">
                    <x-label for="telephone_number" value="Telephone Number" class="text-white" />

                    <x-input id="telephone_number" class="block mt-1 w-full" type="text" name="telephone_number" :value="old('telephone_number')" required />
                </div>

                <div class="mt-3">
                    <x-label for="birthdate" value="Birthdate" class="text-white" />

                    <x-input id="birthdate" class="block mt-1 w-full" type="date" name="birthdate" :value="old('birthdate')" required />
                </div>

                <div class="mt-3">
                    <label for="gender" value="Gender" class="text-white font-medium text-sm">Gender</label>

                    <input id="gender" class="ml-5" type="radio" name="gender" value="Male"/>
                    <label class="text-gray-400 text-sm mr-5">Male</label>
                    <input id="gender" type="radio" name="gender" value="Female" />
                    <label class="text-gray-400 text-sm">Female</label>
                </div>

                <div class="mt-3">
                    <x-label value="Mobile Numbers" class="text-white" />

                    <div id="phones">
                        <x-input placeholder="+20" class="block mt-1" type="text" name="phone1" required />
                    </div>
                    
                    <div onclick="addPhone()" class="text-center bg-blue-500 text-white text-medium px-3 py-2 mt-3 rounded-md shadow-sm hover:bg-blue-400">
                        Add Phone
                    </div>

                    <script>
                        var phones = 2;
                        var phone_input = document.getElementById('phones');

                        function addPhone() {
                            var phone = document.createElement('input');
                            phone.setAttribute('type', 'text');
                            phone.setAttribute('name', 'phone' + phones);
                            phone.setAttribute('placeholder', '+20');
                            phone.setAttribute('required', '');
                            phone.setAttribute('class', 'block mt-1');

                            phone_input.appendChild(phone);

                            phones++;
                        }
                    </script>
                </div>

                <div class="mt-6">
                    <div class="mt-3 mx-auto text-right">
                        <x-button>
                            Next
                        </x-button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-base-layout>