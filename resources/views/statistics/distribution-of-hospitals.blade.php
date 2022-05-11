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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js"
                integrity="sha512-QSkVNOCYLtj73J4hbmVoOV6KVZuMluZlioC+trLpewV8qMjsWqlIQvkn1KGX2StWvPMdWGBqim1xlC8krl1EKQ=="
                crossorigin="anonymous" referrerpolicy="no-referrer"></script>
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
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>City</th>
                            <th>Available beds</th>
                            <th>Total hospitals</th>
                            <th>Isolation hospitals</th>
                            <th>Total hospitalizations</th>
                        </tr>
                    </thead>


                    <tbody>
                        @for ($i = 0, $j = 0; $i < count($cities); $i++)
                            <tr>
                                <td>{{ $cities[$i] }}</td>
                                @if (isset($data_by_city[$j]))
                                    @if ($data_by_city[$j]->city == $cities[$i])
                                        <td>{{ $data_by_city[$j]->avail_beds }}</td>
                                        <td>{{ $data_by_city[$j]->total_hospitals }}</td>
                                        <td>{{ $data_by_city[$j]->iso_hospitals }}</td>
                                        <td>{{ $data_by_city[$j]->total_hospitalization }}</td>
                                        @php $j++ @endphp
                                    @else
                                        <td>0</td>
                                        <td>0</td>
                                        <td>0</td>
                                        <td>0</td>
                                    @endif
                                @else
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                @endif
                            </tr>
                        @endfor
                    </tbody>
                </table>
            @elseif(isset($data_by_hospital))
                <h1>{{ $report_title }}</h1>
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
            @endif
        </div>
    </div>
    <script src="{{ asset('js/statistics.js') }}"></script>
</x-app-layout>
