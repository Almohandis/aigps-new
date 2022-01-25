<x-base-layout>
    <div class="mt-6 grid grid-flow-col ">
        <div class="flex flex-col">
            <a href="#" class="mx-auto mt-2 text-center bg-white text-blue-500 text-lg px-4 py-2 shadow-md rounded-md hover:bg-blue-400 w-full">
                Pandemic Statistics
            </a>
            <a href="#" class="mx-auto mt-2 text-center bg-blue-500 text-white text-lg px-4 py-2 shadow-md rounded-md hover:bg-blue-400 w-full">
                Isolation Hospitals
            </a>
            <a href="#" class="mx-auto mt-2 text-center bg-white text-blue-500 text-lg px-4 py-2 shadow-md rounded-md hover:bg-blue-400 w-full">
                Campaign Statistics
            </a>
        </div>

        <div class="ml-2">
            <img src="{{ asset('map.jpg') }}" class="px-2 mt-5">

            <div class="mx-2 mt-5 bg-black bg-opacity-50 p-5">
                <div class="text-xl font-bold text-white text-center">Isolation Hosptials Statistics</div>
                <div class="mx-auto w-48 bg-white bg-opacity-50 h-px p-0"></div>
            
                <div class="grid grid-cols-3 w-full">
                    <div class="">
                        <div class="text-xl text-red-500 text-center">15,000</div>
                        <div class="text-large font-bold text-white text-center">Isolation Hospitals</div>
                    </div>

                    <div class="">
                        <div class="text-xl text-yellow-500 text-center">85,000</div>
                        <div class="text-large font-bold text-white text-center">Beds</div>
                    </div>
                    
                    <div class="">
                        <div class="text-xl text-green-400 text-center">9,865</div>
                        <div class="text-large font-bold text-white text-center">Room</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-base-layout>