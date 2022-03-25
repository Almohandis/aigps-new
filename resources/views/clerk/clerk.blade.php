<x-app-layout>
    <div class="mt-6">
        <div class="mx-auto text-center mt-5">

            <form class="inline-block bg-black bg-opacity-50 p-8 text-justify" method="POST" action="/staff/clerk"
                style="background-color: white;box-shadow: 0 .5rem 1.5rem rgba(0,0,0,.1);border-radius: 25px;">
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

                @isset($success)
                    <div class="font-medium text-green-600">
                        {{ $success }}
                    </div>
                @endisset

                @csrf
                <div style="width: 21rem;margin-top: 3rem;margin-left: 6rem;">
                    <x-label for="national_id" value="National Id" class="text-black" />

                    <x-input oninput="validateNid(this)" class="block mt-1 w-full" type="text" name="national_id" :value="old('national_id')"
                        style="width: 16rem;margin-left: 5rem;margin-top: -2rem;" required autofocus />

                    <script>
                        function validateNid(input) {
                            if (input.value.length != 14 || isNaN(input.value) || !(input.value[0] == '2' || input.value[0] == '1' || input.value[0] == '3')) {
                                input.style.outline = "red solid thin";
                            } else {
                                input.style.outline = "green solid thin";
                            }
                        }
                    </script>
                        
                </div>

                <div style="margin-left: 40rem;margin-top: -2rem;">
                    <x-label for="city" value="City" class="text-black" />

                    <select name="city" class="block mt-1 w-full"
                        style="width: 12rem;margin-left: 3rem;margin-top: -2rem;border-radius: 5px;">
                        <option value="Alexandria">Alexandria</option>
                        <option value="Aswan">Aswan</option>
                        <option value="Asyut">Asyut</option>
                        <option value="Beheira">Beheira</option>
                        <option value="Beni Suef">Beni Suef</option>
                        <option value="Cairo">Cairo</option>
                        <option value="Dakahlia">Dakahlia</option>
                        <option value="Damietta">Damietta</option>
                        <option value="Faiyum">Faiyum</option>
                        <option value="Gharbia">Gharbia</option>
                        <option value="Giza">Giza</option>
                        <option value="Helwan">Helwan</option>
                        <option value="Ismailia">Ismailia</option>
                        <option value="Kafr El Sheikh">Kafr El Sheikh</option>
                        <option value="Luxor">Luxor</option>
                        <option value="Matruh">Matruh</option>
                        <option value="Minya">Minya</option>
                        <option value="Monufia">Monufia</option>
                        <option value="New Valley">New Valley</option>
                        <option value="North Sinai">North Sinai</option>
                        <option value="Port Said">Port Said</option>
                        <option value="Qalyubia">Qalyubia</option>
                        <option value="Qena">Qena</option>
                        <option value="Red Sea">Red Sea</option>
                        <option value="Sharqia">Sharqia</option>
                        <option value="Sohag">Sohag</option>
                        <option value="South Sinai">South Sinai</option>
                        <option value="Suez">Suez</option>
                        <option value="6th of October">6th of October</option>
                    </select>
                </div>
                <div style="margin-left: 5rem;margin-top: 4rem;">
                    <x-label for="vaccine_name" value="Vaccine name" class="text-black" />

                    <x-input style="width: 16rem;margin-left: 6rem;margin-top: -2rem;" class="block mt-1 w-full"
                        type="text" name="vaccine_name" :value="old('vaccine_name')" />
                </div>

                <div style="margin-top: -1.8rem;margin-left: 40rem;">
                    <x-label for="blood_type" value="blood_type" class="text-black" />

                    <select name="blood_type" class="block mt-1 w-full"
                        style="width: 7rem;margin-left: 6rem;margin-top: -2rem;border-radius: 5px;">
                        <option value="A+">A+</option>
                        <option value="A-">A-</option>
                        <option value="B+">B+</option>
                        <option value="B-">B-</option>
                        <option value="AB+">AB+</option>
                        <option value="AB-">AB-</option>
                        <option value="O+">O+</option>
                        <option value="O-">O-</option>
                    </select>
                </div>

                <div class="mt-3" style="margin-left: 11rem;margin-top: 3rem;">
                    <input type="checkbox" name="is_diagnosed" value="true" />
                    <x-label value="Is Diagnosed" class="text-black inline-block" />
                </div>

                <div class="mt-4" style="margin-top: 3rem;margin-left:4rem;">
                    <p class="text-xl text-black"> Infection status </p>
                    <div style="margin-left: 2rem;margin-top: 1rem;">
                        <x-label value="Infection Date:" class="text-black inline-block" />
                        <input
                            style="border-width: 2px;width: 16rem;text-align: center;border-radius: 5px;height: 2.5rem;"
                            type="date" name="infection" />
                    </div>
                    <br>
                    <div style="margin-top: -3.5rem;margin-left: 40rem;">
                        <input type="checkbox" name="is_recovered" value="true" />
                        <x-label value="Is Recovered" class="text-black inline-block" />
                    </div>
                </div>

                <div class="mt-3" style="margin-top: 3rem; margin-left:4rem;">
                    <p class="text-xl text-black"> Chronic Diseases </p>

                    <div id="diseases" style="margin-top: 2rem;margin-left: 8rem;">
                    </div>

                    <div onclick="addDisease()"
                    style="width: 8rem;margin-left: 8rem;"
                        class="text-center bg-blue-500 text-white text-medium px-3 py-2 mt-3 rounded-md shadow-sm hover:bg-blue-400">
                        Add Disease
                    </div>

                    <script>
                        function Scrolldown() {
                            window.scroll(0,550); 
                            }
                        window.onload = Scrolldown;
                        var diseases = 1;
                        var disease_input = document.getElementById('diseases');

                        function addDisease() {
                            var disease = document.createElement('input');
                            disease.setAttribute('type', 'text');
                            disease.setAttribute('name', 'disease' + diseases);
                            disease.setAttribute('placeholder', 'Name');
                            disease.setAttribute('required', '');
                            disease.setAttribute('class', 'block mt-1');

                            disease_input.appendChild(disease);

                            diseases++;
                        }
                    </script>
                </div>


                <div class="mt-6">
                    <div class="mt-3 mx-auto text-right">
                        <button onclick="window.location.href='/'"class="cancel-btn" type="reset" style="margin-right: 1rem;">
                            CANCEL
                        </button>
                        <x-button>
                            Save
                        </x-button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
