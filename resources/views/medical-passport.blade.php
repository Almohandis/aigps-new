<x-app-layout>
    <div class="mt-5 text-center">
        <h1 class="aigps-title">Medical Passport</h1>

        <div class="text-start shadow container bg-white mt-5 rounded p-5 text-dark">
            <h3 class="text-center mb-3">VACCINE CERTIFICATE</h3>

            <table class="table table-striped">
                <tbody>
                    <tr>
                        <th scope="row">Full Name</th>
                        <td>{{ Auth::user()->name }}</td>
                    </tr>

                    <tr>
                        <th scope="row">National ID</th>
                        <td>{{ Auth::user()->national_id }}</td>
                    </tr>
                    
                    <tr>
                        <th scope="row">Date of birth</th>
                        <td>{{ Auth::user()->birthdate }}</td>
                    </tr>

                    <tr>
                        <th scope="row">Blood type</th>
                        <td>{{ Auth::user()->blood_type }}</td>
                    </tr>
                    
                    <tr>
                        <th scope="row">Passport number</th>
                        <td>{{ $passport->passport_number }}</td>
                    </tr>
                    
                    <tr>
                        <th scope="row">Vaccine name</th>
                        <td>{{ $passport->vaccine_name }}</td>
                    </tr>

                    @foreach ($dates as $id => $vaccine_date)
                        <tr>
                            <th scope="row">Dose #{{ $id }} Date</th>
                            <td>{{ $vaccine_date->vaccine_date }}</td>
                        </tr>
                    @endforeach

                    <tr>
                        <th scope="row">QR Code</th>
                        <td> {{ QrCode::size(100)->generate(Auth::user()->national_id) }} </td>
                    </tr>

                    <tr>
                        <th scope="row">Certificate date</th>
                        <td>{{ $date }}</td>
                    </tr>
                </tbody>
            </table>
            
        </div>
    </div>
</x-app-layout>
