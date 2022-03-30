<x-app-layout>
    <link href="{{asset('css/reservation.css')}}" rel="stylesheet">


    <div class="mt-5 text-center">
        <div class="text-start shadow container bg-white mt-5 rounded p-5 text-dark">
            <div class="text-center">
                <img width="100" class="text-center mb-2" src="{{ asset('mioh-logo.png') }}">
            </div>

            <div>
                <div class="alert alert-danger" role="alert">
                    <h3> You cannot reserve vaccines right now, you need to take the survey again after 14 days to insure you have been recovered.</h3>
                </div>
            </div>
            

        </div>
    </div>
</x-app-layout>
