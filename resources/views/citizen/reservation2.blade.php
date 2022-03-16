<x-base-layout>
    <div class="mt-6">
    <img src="{{ asset('vaccine-reserve.jpg') }}" class="sec-header">
        <div class="divide"></div>
        <div class="wrap"></div>
        <h1 class="ml-5 text-left text-4xl text-white" style="text-shadow: 2px 2px 8px #000000;">
            @if (session('message'))
                Diagnose reservation
            @else
                Vaccination reservation
            @endif
        </h1>
        <div class="mx-auto text-center mt-2" style="margin-bottom:4rem;">
            <p class="inline-block text-center text-xl bg-blue-500 font-bold rounded-full text-white w-8 h-8 pt-1" id="c1">1</p>
            <div class="inline-block mx-3 bg-black w-10 h-1 mb-1 bg-opacity-50" id="l2"></div>
            <p class="inline-block text-center text-xl bg-white  font-bold rounded-full text-blue-500  w-8 h-8 pt-1" id="c3">2</p>
            <div class="inline-block mx-3 bg-black w-10 h-1 mb-1 bg-opacity-50" id="l1"></div>
            <p class="inline-block text-center text-xl bg-white  font-bold rounded-full text-blue-500  w-8 h-8 pt-1" id="c2">✓</p>
        </div>

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


        <div class="mx-auto text-center mt-5" style="background-color: #454040;">

            <form class="inline-block bg-black bg-opacity-50 p-8 text-justify" method="POST" action="/reserve/step2" id="reservation-form">
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
                <div id="address-div">
                    <x-label for="address" value="Adress" class="text-white" id="address-label"/>

                    <x-input id="address" class="block mt-1 w-full" type="text" name="address" :value="old('address')"
                        required autofocus />
                </div>

                <div class="country-div">
                    <x-label for="country" value="country" class="text-white" id="country-label"/>

                    <select name="country" id="country" class="block mt-1 w-full">
                        @foreach ($countries as $country)
                            <option value="{{ $country }}">{{ $country }}</option>
                        @endforeach
                    </select>
                </div>
                    <br><br>
                <div class="mt-3" id="tele-div">
                    <x-label for="telephone_number" value="Telephone Number" class="text-white" id="tele-label" />

                    <x-input id="telephone_number" class="block mt-1 w-full" type="number" name="telephone_number"
                        :value="old('telephone_number')" required />
                </div>

                <div class="mt-3" id="birth-div">
                    <x-label for="birthdate" value="Birthdate" class="text-white" id="birth-label" />

                    <x-input id="birthdate" class="block mt-1 w-full" type="date" name="birthdate"
                        :value="old('birthdate')" required />
                </div>
                <br><br>

                <div class="mt-3" id="gender-div">
                    <label for="gender" value="Gender" class="text-white font-medium text-sm" id="gender-label">Gender</label>

                    <input id="gender" class="ml-5" type="radio" name="gender" value="Male" />
                    <label class="text-gray-400 text-sm mr-5" id="gender-type">Male</label>
                    <input id="gender" type="radio" name="gender" value="Female" />
                    <label class="text-gray-400 text-sm" id="gender-type">Female</label>
                </div>
                    <br><br>
                <div class="mt-3" id="mobile-div">
                    <x-label value="Mobile Numbers" class="text-white" id="mobile-label"/>

                    <div id="phones">
                        <x-input placeholder="+20" class="block mt-1" type="number" name="phone1" required id="mobile" />
                    </div>

                    <div onclick="addPhone()" id="addphone"
                        class="text-center bg-blue-500 text-white text-medium px-3 py-2 mt-3 rounded-md shadow-sm hover:bg-blue-400">
                        Add Phone
                    </div>

                    <div id="removePhone" onclick="removePhone()"
                        class="hidden text-center bg-red-500 text-white text-medium px-3 py-2 mt-3 rounded-md shadow-sm hover:bg-red-400">
                        Remove Phone
                    </div>

                    <script>
                        function Scrolldown() {
                            window.scroll(0,550); 
                            }
                        window.onload = Scrolldown;
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
                            phone.style.marginLeft="10rem";
                            phone.style.width="24rem";

                            phone_input.appendChild(phone);

                            phones++;

                            if (phones > 2) {
                                document.getElementById('removePhone').classList.remove('hidden');
                            }
                        }

                        function removePhone() {
                            if (phones > 2) {
                                phone_input.removeChild(phone_input.lastChild);
                                phones--;

                                if (phones == 2) {
                                    document.getElementById('removePhone').classList.add('hidden');
                                }
                            }
                        }
                    </script>
                </div>
                <button onclick="window.location.href='/reserve'"class="back-btn">
                    BACK
                </button>
                <button onclick="window.location.href='/'"class="cancel-btn">
                    CANCEL
                </button>

                <div class="mt-6">
                    <div class="mt-3 mx-auto text-right" id="next-btn">
                        <x-button>
                            Next
                        </x-button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-base-layout>
