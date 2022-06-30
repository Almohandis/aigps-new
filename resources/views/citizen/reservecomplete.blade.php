<x-app-layout>
    <link href="{{ asset('css/reservation.css') }}" rel="stylesheet">


    <div class="mt-5 text-center">
        <h1 class="aigps-title">Reservation confirmation</h1>

        <div class="text-center shadow container bg-white mt-5 rounded p-5 text-dark">
            <img src="{{ asset('checkmark.png') }}" class="aigps-check">

            <p class="text-black mt-2 fw-bold">
                Your request has been successfully submitted, appointment details will be sent in an email, please check
                your inbox.
            </p>

            <a href="/" class="btn btn-success">
                Home
            </a>
        </div>
    </div>
</x-app-layout>
