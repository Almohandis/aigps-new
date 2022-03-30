<x-app-layout>
    <link href="{{asset('css/reservation.css')}}" rel="stylesheet">


    <div class="mt-5 text-center">
        <h1 class="aigps-title">Registeration Complete</h1>

        <div class="text-center shadow container bg-white mt-5 rounded p-5 text-dark">
            <img src="{{ asset('checkmark.png') }}" class="aigps-check">

            <p class="text-black mt-2 fw-bold">
                You have successfully registered to AIGPS. You will recieve a verification Email shortly.
            </p>

            <a href="/login" class="btn btn-success">
                Sign in
            </a>
        </div>
    </div>
</x-app-layout>
