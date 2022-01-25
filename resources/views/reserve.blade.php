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
            <form class="inline-block bg-black bg-opacity-50 p-8 text-justify" method="POST" action="{{ route('login') }}">
                @csrf
                <div>
                    <x-label for="fullname" value="Full Name" class="text-white" />

                    <x-input id="fullname" class="block mt-1 w-full" type="text" name="fullname" :value="old('fullname')" required autofocus />
                </div>

                <div class="mt-3">
                    <x-label for="nationalid" value="National ID" class="text-white" />

                    <x-input id="nationalid" class="block mt-1 w-full" type="text" name="nationalid" :value="old('nationalid')" required />
                </div>

                <div class="mt-3">
                    <x-label for="birthdate" value="Birthdate" class="text-white" />

                    <x-input id="birthdate" class="block mt-1 w-full" type="text" name="birthdate" :value="old('birthdate')" required />
                </div>

                <div class="mt-3">
                    <label for="gender" value="Gender" class="text-white font-medium text-sm">Gender</label>

                    <input id="gender" class="ml-5" type="radio" name="gender" value="Male"/>
                    <label class="text-gray-400 text-sm mr-5">Male</label>
                    <input id="gender" type="radio" name="gender" value="Female" />
                    <label class="text-gray-400 text-sm">Female</label>
                </div>

                <div class="mt-3">
                    <x-label for="email" value="Email (optional)" class="text-white" />

                    <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
                </div>

                <div class="mt-3">
                    <x-label for="phone" value="Mobile Number" class="text-white" />

                    <x-input placeholder="+20" id="phone" class="inline-block mt-1 w-3/4" type="text" name="phone" :value="old('phone')" required />
                    <a class="text-center bg-blue-500 text-white text-medium px-3 py-2 rounded-md shadow-sm hover:bg-blue-400">
                        Send
                    </a>

                    <div class="block mt-4">
                        <label for="whatsapp" class="inline-flex items-center text-white">
                            <input id="whatsapp" type="checkbox" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" name="remember">
                            <span class="ml-2 text-sm text-gray-400">WhatsApp Registered</span>
                        </label>
                    </div>
                </div>

                <div class="mt-3">
                    <x-label for="verification" value="Verification Code" class="text-white" />

                    <div class="mx-auto text-center mt-1">
                        <x-input id="verification" class="w-10" type="text" name="code1" required />
                        <x-input id="verification" class="w-10 ml-3" type="text" name="code2" required />
                        <x-input id="verification" class="w-10 ml-3" type="text" name="code3" required />
                        <x-input id="verification" class="w-10 ml-3" type="text" name="code4" required />
                    </div>
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