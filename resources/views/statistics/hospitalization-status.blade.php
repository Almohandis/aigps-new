<x-app-layout>
    <style>
        #submit-btn {
            display: none;
        }

    </style>
    <div class="table-responsive text-start shadow container bg-white mt-5 rounded px-5 py-3 text-dark">
        <div class="notification">
            @if (session('message'))
                {{ session('message') }}
            @endif
        </div>
        <div class="pt-8 sm:pt-0">
            <form action="/print" method="POST">
                @csrf
                <input type="hidden" name="table" id="table">
                <input type="hidden" name="title" id="title">
                <button type="submit" id="print-btn" class="btn btn-primary">Download as PDF</button>
            </form>
            <form id="form" action="/stats" method="POST" class="row">
                @csrf
                <div class="col-12 col-md-4 mt-3">
                    <select name="report_name" id="report-name" class="form-control">
                        <option disabled hidden selected>Please choose a report name</option>
                        @foreach ($names as $name)
                            <option value="{{ $name }}">{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 col-md-4 mt-3">
                    <select name="report_by" id="report-by" class="form-control"></select>
                </div>
                <div id="submit-btn" class="col-12 col-md-4 mt-3 row">
                    <div>
                        <button type="submit" id="generate-btn" class="btn btn-primary">Generate report</button>
                    </div>
                </div>
            </form>
            @if (isset($data_by_city))
                <h1>{{ $report_title }}</h1>
                <h4>Date: {{ date('M d, Y') }}</h4>
                <h4>Time: {{ date('h:i A') }}</h4>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>City</th>
                            <th>Total capacity</th>
                            <th>Available beds</th>
                            <th>Total hospitalizations</th>
                            <th>Total hospitals</th>
                            <th>Isolation hospitals</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($data_by_city as $city)
                            <tr>
                                <td>{{ $city->city }}</td>
                                <td>{{ $city->total_capacity }}</td>
                                <td>{{ $city->avail_beds }}</td>
                                <td>{{ $city->total_hospitalization }}</td>
                                <td>{{ $city->total_hospitals }}</td>
                                <td>{{ $city->iso_hospitals }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
        </div>
    @elseif(isset($data_by_hospital))
        <h1>{{ $report_title }}</h1>
        <h4>Date: {{ date('M d, Y') }}</h4>
        <h4>Time: {{ date('h:i A') }}</h4>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Hospital name</th>
                    <th>City</th>
                    <th>Is isolation</th>
                    <th>Capacity</th>
                    <th>Available beds</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($data_by_hospital as $hospital)
                    <tr>
                        <td>{{ $hospital->name }}</td>
                        <td>{{ $hospital->city }}</td>
                        <td>{{ $hospital->is_iso }}</td>
                        <td>{{ $hospital->capacity }}</td>
                        <td>{{ $hospital->avail_beds }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @elseif(isset($data_by_date))
        <h1>{{ $report_title }}</h1>
        <h4>Date: {{ date('M d, Y') }}</h4>
        <h4>Time: {{ date('h:i A') }}</h4>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Hospitalization date</th>
                    <th>Number of males</th>
                    <th>Male percentage</th>
                    <th>Number of females</th>
                    <th>Female percentage</th>
                    <th>Total patients</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($data_by_date as $date)
                    <tr>
                        <td>{{ $date->hoz_date }}</td>
                        <td>{{ $date->male }}</td>
                        <td>{{ $date->male_pcnt }}</td>
                        <td>{{ $date->female }}</td>
                        <td>{{ $date->female_pcnt }}</td>
                        <td>{{ $date->total }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @elseif(isset($data_by_age))
        <h1>{{ $report_title }}</h1>
        <h4>Date: {{ date('M d, Y') }}</h4>
        <h4>Time: {{ date('h:i A') }}</h4>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Age segment</th>
                    <th>Number of males</th>
                    <th>Male percentage</th>
                    <th>Number of females</th>
                    <th>Female percentage</th>
                    <th>Total patients</th>
                </tr>
            </thead>
            @php
                $second = $data_by_age[1];
                $data_by_age[1] = $data_by_age[2];
                $data_by_age[2] = $second;
            @endphp
            <tbody>
                @foreach ($data_by_age as $age)
                    <tr>
                        <td>{{ $age->age }}</td>
                        <td>{{ $age->male }}</td>
                        <td>{{ $age->male_pcnt }}</td>
                        <td>{{ $age->female }}</td>
                        <td>{{ $age->female_pcnt }}</td>
                        <td>{{ $age->total }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
    </div>
    <script src="{{ asset('js/statistics.js') }}"></script>
</x-app-layout>
