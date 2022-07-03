<x-app-layout>
    <div class="mt-5 text-center">
        <h1 class="aigps-title">Medical Passport</h1>

        <div class="text-start shadow container bg-white mt-5 rounded p-5 text-dark">
            <h3 class="text-center mb-4">VACCINE CERTIFICATE COVID-19</h3>

            <div id="medicalPassportTable">
                <table class="table table-striped">
                    <tbody>
                        <tr>
                            <th colspan="2" class="text-center py-3">
                                <h5> Personal Data </h5>
                            </th>
                        </tr>
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
                            <th colspan="2" class="text-center py-3">
                                <h5> Vaccine Status </h5>
                            </th>
                        </tr>

                        @foreach ($dates as $id => $vaccine_date)
                            <tr>
                                <th scope="row">{{ $id + 1 }}- Vaccine dose name</th>
                                <td>{{ $passport->vaccine_name }}, was taken on {{ $vaccine_date->vaccine_date }}
                                </td>
                            </tr>

                            {{-- <tr>
                                <th scope="row">{{ $id + 1 }}- Vaccine dose Date</th>
                                <td>{{ $vaccine_date->vaccine_date }}</td>
                            </tr> --}}
                        @endforeach

                        @if (count($infections) > 0)
                            <tr>
                                <th colspan="2" class="text-center py-3">
                                    <h5> Previous Infections </h5>
                                </th>
                            </tr>

                            @foreach ($infections as $index => $infection)
                                <tr>
                                    <th scope="row">Infection #{{ $index + 1 }} date</th>
                                    <td>{{ $infection->infection_date }}</td>
                                </tr>
                            @endforeach
                        @endif

                        {{-- @if (count($chronic_diseases) > 0)
                            <tr>
                                <th colspan="2" class="text-center py-3">
                                    <h5> Chronic Diseases</h5>
                                </th>
                            </tr>

                            @foreach ($chronic_diseases as $index => $chronic_disease)
                                <tr>
                                    <th scope="row">Chronic Disease #{{ $index + 1 }}</th>
                                    <td>{{ $chronic_disease->name }}</td>
                                </tr>
                            @endforeach
                        @endif --}}

                        <tr>
                            <th colspan="2" class="text-center py-3">
                                <h5> Medical Passport Data </h5>
                            </th>
                        </tr>

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

            <div class="row justify-content-center">
                <button class="btn btn-primary" onclick="createPDF()">Print</button>
            </div>

            <script>
                function createPDF() {
                    var sTable = document.getElementById('medicalPassportTable').innerHTML;

                    var style = "<style>";
                    style = style + "table {width: 100%;font: 17px Calibri;}";
                    style = style + "table, th, td {border: solid 1px #DDD; border-collapse: collapse;";
                    style = style + "padding: 2px 3px;text-align: center;}";
                    style = style + "</style>";

                    var win = window.open('', '', 'height=700,width=700');

                    win.document.write('<html><head>');
                    win.document.write('<title>Profile</title>');
                    win.document.write(style);
                    win.document.write('</head>');
                    win.document.write('<body>');
                    win.document.write(sTable);
                    win.document.write('</body></html>');

                    win.document.close();

                    win.print();
                }
            </script>
        </div>
    </div>
</x-app-layout>
