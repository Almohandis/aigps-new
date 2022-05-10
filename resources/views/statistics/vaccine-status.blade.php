<x-app-layout>
    <div class="table-responsive text-start shadow container bg-white mt-5 rounded px-5 py-3 text-dark">
        <div class="notification">
            @if (session('message'))
                {{ session('message') }}
            @endif
        </div>
        <style>
            .tr {
                display: table-cell;
            }

            .td {
                display: block;
            }

        </style>
        <div class="pt-8 sm:pt-0">
            <form id="form" action="/stats" method="POST">
                @csrf
                <select name="report_name" id="report-name" class="form-control">
                    <option disabled hidden selected>Please choose a report name</option>
                    @foreach ($names as $name)
                        <option value="{{ $name }}">{{ $name }}</option>
                    @endforeach
                </select>
                <select name="report_by" id="report-by" class="form-control"></select>
                <button type="submit" id="generate-btn" class="btn btn-primary">Generate report</button>
            </form>
            @if (isset($data_by_vaccine_status))
                <h1>{{ $report_title }}</h1>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Vaccine status category</th>
                            <th>Number of males</th>
                            <th>Male percentage</th>
                            <th>Number of females</th>
                            <th>Female percentage</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                
                    <tbody>
                        @foreach ($data_by_vaccine_status as $status)
                            <tr>
                                <td>{{ $status->vac_status }}</td>
                                <td>{{ $status->male_count }}</td>
                                <td>{{ $status->male_pcnt }}</td>
                                <td>{{ $status->female_count }}</td>
                                <td>{{ $status->female_pcnt }}</td>
                                <td>{{ $status->total }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @elseif(isset($data_by_city_age_segment))
                <h1>{{ $report_title }}</h1>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>City</th>
                            <th>Age segment</th>
                            <th>Not vaccinated</th>
                            <th>Partially vaccinated</th>
                            <th>Fully vaccinated</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                
                    <tbody>
                        @foreach ($data_by_city_age_segment as $city)
                            <tr>
                                <td>{{ $city->city }}</td>
                                <td>{{ $city->age }}</td>
                                <td>{{ $city->not_vac }}</td>
                                <td>{{ $city->part_vac }}</td>
                                <td>{{ $city->full_vac }}</td>
                                <td>{{ $city->total }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
    <script src="{{ asset('js/statistics.js') }}"></script>
</x-app-layout>
