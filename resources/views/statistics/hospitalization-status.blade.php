<x-app-layout>
    <div class="table-responsive text-start shadow container bg-white mt-5 rounded px-5 py-3 text-dark">
        <div class="notification">
            @if (session('message'))
                {{ session('message') }}
            @endif
        </div>
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
                    </table>
                </div>
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
            @elseif(isset($data_by_date))
                <h1>{{ $report_title }}</h1>
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
