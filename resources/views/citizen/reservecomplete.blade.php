<x-base-layout>
    <div class="mt-10 mx-auto text-center">
        <div class="mx-auto text-center mt-2" style="margin-top:8rem;">
            <p class="inline-block text-center text-xl bg-blue-500 font-bold rounded-full text-white w-8 h-8 pt-1" id="c1">1</p>
            <div class="inline-block mx-3 bg-black w-10 h-1 mb-1 bg-opacity-50" id="l2"></div>
            <p class="inline-block text-center text-xl bg-white  font-bold rounded-full text-blue-500  w-8 h-8 pt-1" id="c3">2</p>
            <div class="inline-block mx-3 bg-black w-10 h-1 mb-1 bg-opacity-50" id="l2"></div>
            <p class="inline-block text-center text-xl bg-white  font-bold rounded-full text-blue-500  w-8 h-8 pt-1" id="c3">✓</p>
        </div>
        <div class="mx-auto inline-block bg-black bg-opacity-50 p-8 text-justify w-[300] text-center">
            <img src="{{ asset('checkmark.png') }}" class="w-10 h-10 mx-auto">
            <p class="text-white text-center mt-2 font-bold" style="font-size:20px;">
                Your request has been successfully submitted Appointment details will be sent in a SMS.
            </p>

            <div class="mt-6">
                <div class="mt-3 mx-auto text-center mr-5">
                    <a href="/" class="inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Home
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-base-layout>