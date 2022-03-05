<x-base-layout>
    <div class="mt-6">
        <h1 class="ml-5 text-left text-4xl text-white" style="text-shadow: 2px 2px 8px #000000;">
            Medical passport
        </h1>

        <div class="mx-auto text-center mt-5">

            <div class="inline-block bg-black bg-opacity-50 p-8 text-justify">
                <h1>VACCINE CERTIFICATE</h1>
                <p>Full name: {{ $user->name }}</p>
                <p>National ID: {{ $user->national_id }}</p>
                <p>Date of birth: {{ $user->birthdate }}</p>
                <p>Blood type: {{ $user->blood_type }}</p>
                <p>Passport number: {{ $user->passport_number }}</p>
                <p>Vaccine name: {{ $medical_passport->vaccine_name }}</p>
                <p>Dose dates</p>
                @foreach ($vaccine_dates as $vaccine_date)
                    <p>{{ $vaccine_date->vaccine_date }}</p>
                @endforeach
                <br><br>
                <p>Certificate date: {{ $date }}</p>
            </div>
        </div>
</x-base-layout>
