<x-app-layout>
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 mt-9">
        <div class="notification">
            @if (session('message'))
                {{ session('message') }}
            @endif
        </div>
        <style>
            table {
                display: table;
            }

            table tr {
                display: table-cell;
            }

            table tr td {
                display: block;
            }

        </style>
        <div class="pt-8 sm:pt-0">
            <h1>statistics</h1><br>
            <form action="/stats/report" method="POST">
                @csrf
                <select name="report_name" id="report-name">
                    <option disabled hidden selected>Please choose a report name</option>
                    @foreach ($names as $name)
                        <option value="{{ $name }}">{{ $name }}</option>
                    @endforeach
                </select>
                <select name="report_by" id="report-by"></select>
                <button type="submit" class="btn btn-primary">Generate report</button>
            </form>
            @if (isset($data))
                <div>
                    <form>
                        <tr>
                            <th>City</th>
                            <th>A+</th>
                            <th>A-</th>
                            <th>B+</th>
                            <th>B-</th>
                            <th>AB+</th>
                            <th>AB-</th>
                            <th>O+</th>
                            <th>O-</th>
                        </tr>
                        @foreach ($data as $cities)
                            @foreach ($cities as $blood_city)
                                @foreach ($blood_city as $key => $value)
                                    <tr>
                                        <td>{{ $blood_city->city }}</td>
                                        <td>{{ $blood_city->A_plus }}</td>
                                        <td>{{ $blood_city->A_minus }}</td>
                                        <td>{{ $blood_city->B_plus }}</td>
                                        <td>{{ $blood_city->B_minus }}</td>
                                        <td>{{ $blood_city->AB_plus }}</td>
                                        <td>{{ $blood_city->AB_minus }}</td>
                                        <td>{{ $blood_city->O_plus }}</td>
                                        <td>{{ $blood_city->O_minus }}</td>
                                    </tr>
                                @endforeach
                            @endforeach
                        @endforeach
                    </form>
                </div>
            @endif
        </div>
    </div>
    <script src="{{ asset('js/statistics.js') }}"></script>
</x-app-layout>
