<x-app-layout>
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 mt-9">
        <div class="notification">
            @if (session('message'))
                {{ session('message') }}
            @endif
        </div>
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
                        <th>Number of males</th>
                        <th>Males percentage</th>
                        <th>Number of females</th>
                        <th>Females percentage</th>
                        <th>Total number of infections</th>
                        <th>Total hospitals</th>
                        <th>Average available beds</th>
                    </tr>
                    @for ($i = 0, $j = 0; $i < count($cities); $i++)
                        <tr>
                            <td>{{ $cities[$i] }}</td>
                            @if (isset($data_by_city[$j]))
                                @if ($cities[$i] == $data_by_city[$j]->city)
                                    <td>{{ $data_by_city[$j]->male_count }}</td>
                                    <td>{{ $data_by_city[$j]->male_pcnt }}</td>
                                    <td>{{ $data_by_city[$j]->female_count }}</td>
                                    <td>{{ $data_by_city[$j]->female_pcnt }}</td>
                                    <td>{{ $data_by_city[$j]->total_infections }}</td>
                                    <td>{{ $data_by_city[$j]->tot_hos }}</td>
                                    <td>{{ $data_by_city[$j]->avg_avail_beds }}</td>
                                    @php $j++ @endphp
                                @else
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
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
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                            @endif
                        </tr>
                    @endfor
                </table>
            @elseif(isset($data_by_vaccine_status))
                <table>
                    <tr>
                        <th>Vaccine status</th>
                        <th>Number of males</th>
                        <th>Males percentage</th>
                        <th>Number of females</th>
                        <th>Female percentage</th>
                        <th>Total number of infections</th>
                    </tr>
                    @foreach ($data_by_vaccine_status as $vac)
                        <tr>
                            <td>{{ $vac->vac_status }}</td>
                            <td>{{ $vac->male_count }}</td>
                            <td>{{ $vac->male_pcnt }}</td>
                            <td>{{ $vac->female_count }}</td>
                            <td>{{ $vac->female_pcnt }}</td>
                            <td>{{ $vac->total }}</td>
                        </tr>
                    @endforeach
                </table>
            @elseif(isset($data_by_date))
                <table>
                    <tr>
                        <th colspan="6">Total number of infections starting from {{ $date }} until now</th>
                    </tr>
                    <tr>
                        <th>Infection date</th>
                        <th>Number of males</th>
                        <th>Males percentage</th>
                        <th>Number of females</th>
                        <th>Females percentage</th>
                        <th>Total infections</th>
                    </tr>
                    @foreach ($data_by_date as $date)
                        <tr>
                            <td>{{ $date->infection_date }}</td>
                            <td>{{ $date->male_count }}</td>
                            <td>{{ $date->male_pcnt }}</td>
                            <td>{{ $date->female_count }}</td>
                            <td>{{ $date->female_pcnt }}</td>
                            <td>{{ $date->total_inf }}</td>
                        </tr>
                    @endforeach
                </table>
            @elseif(isset($data_by_age))
                <table>
                    <tr>
                        <th>Age segment</th>
                        <th>Number of males</th>
                        <th>Male percentage</th>
                        <th>Number of females</th>
                        <th>Female percentage</th>
                        <th>Total infections</th>
                    </tr>
                    @foreach ($data_by_age as $segment)
                        <tr>
                            <td>{{ $segment->age }}</td>
                            <td>{{ $segment->male }}</td>
                            <td>{{ $segment->male_pcnt }}</td>
                            <td>{{ $segment->female }}</td>
                            <td>{{ $segment->female_pcnt }}</td>
                            <td>{{ $segment->total }}</td>
                        </tr>
                    @endforeach
                </table>
            @endif
        </div>
    </div>
    <script src="{{ asset('js/statistics.js') }}"></script>
</x-app-layout>
