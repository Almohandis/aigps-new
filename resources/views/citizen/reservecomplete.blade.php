<x-base-layout>
    <div class="mt-10 mx-auto text-center">
        <div class="mx-auto inline-block bg-black bg-opacity-50 p-8 text-justify w-[300] text-center">
            <img src="{{ asset('checkmark.png') }}" class="w-10 h-10 mx-auto">
            <p class="text-white text-center mt-2 font-bold">
                Your request has been successfully submitted
            </p>
            <p class="text-white text-center mt-2">
                Appointment details will be sent in a sms or you will find it in notifications
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