<x-app-layout>
    <link href="{{asset('css/reservation.css')}}" rel="stylesheet">


    <div class="mt-5 text-center">
        <h1 class="aigps-title">Survey</h1>

        <div class="text-start shadow container bg-white mt-5 rounded p-5 text-dark">
            <div class="text-center">
                <img width="100" class="text-center mb-2" src="{{ asset('mioh-logo.png') }}">
            </div>

            <x-help-modal></x-help-modal>
            @if ($errors->any())
                <div>
                    <div class="alert alert-danger" role="alert">
                        <p>Something went wrong. Please check the form below for errors.</p>

                        <ul class="">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <form action="/survey" method="POST" id="procceed_form" class="text-center">
                @csrf

                @foreach ($questions as $question)
                    <div class="mt-3 row text-start">
                        <label class="text-black col-12 col-md-9"> {{ $question->title }} </label>
                        <div class="d-flex radio col-12 col-md-3 justify-content-center">
                            <input class="form-check-input me-2" type="radio" name="answers[{{ $question->id }}]" value="Yes">
                            <label class="me-3">Yes</label>
                            <input class="form-check-input me-2" type="radio" name="answers[{{ $question->id }}]" value="No">
                            <label class="text-gray-400 text-sm">No</label>
                        </div>
                    </div>
                    <br>
                @endforeach

                <button class="btn btn-success mt-5" type="submit" id="procceed_button" style="width: 200px;">
                    Submit
                </button>
            </form>
        </div>
    </div>
</x-app-layout>
