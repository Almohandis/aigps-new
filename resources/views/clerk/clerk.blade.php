<x-app-layout>
    <div class="mt-6">
        <h1 class="ml-5 text-left text-4xl text-white" style="text-shadow: 2px 2px 8px #000000;">
            Campaign Clerk
        </h1>

        <div class="mx-auto text-center mt-5">
            
            <form class="inline-block bg-black bg-opacity-50 p-8 text-justify" method="POST" action="/staff/clerk">
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
                <div>
                    <x-label for="national_id" value="National Id" class="text-white" />

                    <x-input class="block mt-1 w-full" type="text" name="national_id" :value="old('national_id')" required autofocus />
                </div>

                <div>
                    <x-label for="city" value="City" class="text-white" />

                    <select name="city" class="block mt-1 w-full">
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

                <div>
                    <x-label for="blood_type" value="blood_type" class="text-white" />

                    <select name="blood_type" class="block mt-1 w-full">
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

                <div class="mt-3">
                    <input type="checkbox" name="is_diagnosed" value="true" />
                    <x-label value="Is Diagnosed" class="text-white inline-block" />
                </div>

                <div class="mt-4 text-white">
                    <p class="text-xl"> Infection status </p>
                    <input type="checkbox" name="is_infected" value="true" />
                    <x-label value="Is Infected" class="text-white inline-block" />
                    <br>
                    <input type="checkbox" name="is_recovered" value="true" />
                    <x-label value="Is Recovered" class="text-white inline-block" />
                </div>
                
                <div class="mt-3">
                    <p class="text-xl text-white"> Chronic Diseases </p>

                    <div id="diseases">
                    </div>
                    
                    <div onclick="addDisease()" class="text-center bg-blue-500 text-white text-medium px-3 py-2 mt-3 rounded-md shadow-sm hover:bg-blue-400">
                        Add Disease
                    </div>

                    <script>
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
                        <x-button>
                            Save
                        </x-button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>