<x-app-layout>
    <link href="{{asset('css/welcome.css')}}" rel="stylesheet">

    <!-- background video  -->
    <video autoplay muted loop class="background-video" width="100%">
        <source src="{{asset('background.mp4')}}" type="video/mp4">
    </video>


    <div class="container aigps-welcome-content text-left">
        <h1 class="text-black aigps-title">AIGPS</h1>

        <p class="text-dark mt-1">
            The new AI system that is used as a tool <br> to support the fight against any viral pandemic.
        </p>

        <div class="flex my-md">
            <a href="/reserve" class="shadow btn btn-success btn-md">
                Reserve Vaccine
            </a>

            <a href="/reserve/hospital" class="shadow btn btn-dark btn-md">
                Reserve Isolation Hospital
            </a>
        </div>
    </div>
</x-app-layout>
