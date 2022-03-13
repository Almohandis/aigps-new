<x-app-layout>
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 mt-9">
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
            <h1>statistics</h1><br>
            <form id="form" action="/stats" method="POST">
                @csrf
                <select name="report_name" id="report-name">
                    <option disabled hidden selected>Please choose a report name</option>
                    @foreach ($names as $name)
                        <option value="{{ $name }}">{{ $name }}</option>
                    @endforeach
                </select>
                <select name="report_by" id="report-by"></select>
                <button type="submit" id="generate-btn" class="btn btn-primary">Generate report</button>
            </form>
            @if (isset($data_by_city))
                <table>
                    <tr>
                        <th>City</th>
                        <th>Total recoveries</th>
                        <th>Total hospitals</th>
                        <th>Average available beds</th>
                    </tr>
                    @for ($i = 0, $j = 0; $i < count($cities); $i++)
                        <tr>
                            <td>{{ $cities[$i] }}</td>
                            @if (isset($data_by_city[$j]))
                                @if ($cities[$i] == $data_by_city[$j]->city)
                                    <td>{{ $data_by_city[$j]->total_rec }}</td>
                                    <td>{{ $data_by_city[$j]->tot_hos }}</td>
                                    <td>{{ $data_by_city[$j]->avg_avail_beds }}</td>
                                    @php $j++ @endphp
                                @else
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                @endif
                            @else
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                            @endif
                        </tr>
                    @endfor
                </table>
            @elseif(isset($data_by_hospital))
                <table>
                    <tr>
                        <th>Hospital name</th>
                        <th>City</th>
                        <th>Total recoveries</th>
                        <th>Available beds</th>
                    </tr>
                    @foreach ($data_by_hospital as $hospital)
                        <tr>
                            <td>{{ $hospital->name }}</td>
                            <td>{{ $hospital->city }}</td>
                            <td>{{ $hospital->total_recoveries }}</td>
                            <td>{{ $hospital->avail_beds }}</td>
                        </tr>
                    @endforeach
                </table>
            @elseif(isset($data_by_date))
                <table>
                    <tr>
                        <th colspan="2">Total number of recoveries starting from {{ $date }} until now</th>
                    </tr>
                    <tr>
                        <th>Date</th>
                        <th>Total recoveries</th>
                    </tr>
                    @foreach ($data_by_date as $date)
                        <tr>
                            <td>{{ $date->infection_date }}</td>
                            <td>{{ $date->total_rec }}</td>
                        </tr>
                    @endforeach
                </table>
            @elseif(isset($data_by_age))
                <table>
                    <tr>
                        <th>Age segment</th>
                        <th>Total recoveries</th>
                        <th>Number of males</th>
                        <th>Male percentage</th>
                        <th>Number of females</th>
                        <th>Female percentage</th>
                    </tr>
                    @foreach ($data_by_age as $segment)
                        <tr>
                            <td>{{ $segment->Age }}</td>
                            <td>{{ $segment->Total }}</td>
                            <td>{{ $segment->Male }}</td>
                            <td>{{ $segment->male_pcnt }}</td>
                            <td>{{ $segment->Female }}</td>
                            <td>{{ $segment->female_pcnt }}</td>
                        </tr>
                    @endforeach
                </table>
            @endif
        </div>
    </div>
    <script src="{{ asset('js/statistics.js') }}"></script>
</x-app-layout>
