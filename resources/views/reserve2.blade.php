<x-base-layout>
    <div class="mt-6">
        <h1 class="ml-5 text-left text-4xl text-white" style="text-shadow: 2px 2px 8px #000000;">
            Vaccination Reserve
        </h1>
        
        <div class="mx-auto text-center mt-2">
            <p class="inline-block text-center text-xl bg-white font-bold rounded-full text-blue-500 w-8 h-8 pt-1">1</p>
            <div class="inline-block mx-3 bg-black w-10 h-1 mb-1 bg-opacity-50"></div>
            <p class="inline-block text-center text-xl bg-blue-500 font-bold rounded-full text-white w-8 h-8 pt-1">2</p>
        </div>

        <p class="text-white text-center mt-2">This will be replaced with an actual map when we make the backend</p>

        <div class="mx-auto text-center mt-5">
            <img src="{{ asset('map.jpg') }}" class="mx-auto w-auto h-auto">
        </div>

        <div class="mt-6">
            <div class="mt-3 mx-auto text-right mr-5">
                <x-button>
                    Procceed
                </x-button>
            </div>
        </div>
    </div>
</x-base-layout>