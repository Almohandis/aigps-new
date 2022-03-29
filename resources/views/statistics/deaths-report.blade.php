<x-app-layout>
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 mt-9">
        <div class="notification">
            @if (session('message'))
                {{ session('message') }}
            @endif
        </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js"
                integrity="sha512-QSkVNOCYLtj73J4hbmVoOV6KVZuMluZlioC+trLpewV8qMjsWqlIQvkn1KGX2StWvPMdWGBqim1xlC8krl1EKQ=="
                crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <div class="pt-8 sm:pt-0">
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
                <h1>{{ $report_title }}</h1>
                <div class="tbl-header">
                    <table>
                        <tr>
                            <th>City</th>
                            <th>Number of males</th>
                            <th>Males percentage</th>
                            <th>Number of females</th>
                            <th>Females percentage</th>
                            <th>Total number of deaths</th>
                            <th>Total hospitals</th>
                            <th>Average available beds</th>
                        </tr>
                    </table>
                </div>
                <div class="tbl-content">
                    <table>
                        @foreach ($data_by_city as $city)
                            <tr>
                                <td>{{ $city->city }}</td>
                                <td>{{ $city->male_count }}</td>
                                <td>{{ $city->male_pcnt }}</td>
                                <td>{{ $city->female_count }}</td>
                                <td>{{ $city->female_pcnt }}</td>
                                <td>{{ $city->total_deaths }}</td>
                                <td>{{ $city->tot_hos }}</td>
                                <td>{{ $city->avg_avail_beds }}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
                <div>
                    @php
                        $counter = count($data_by_city);
                        $sum = 0;
                        $mean = 0;
                        $variance = 0;
                        $standard_deviation = 0;

                        foreach ($data_by_city as $city) {
                            $sum += $city->total_deaths;
                        }

                        $mean = round($sum / $counter, 2);

                        $total = $sum;
                        $sum = 0;

                        foreach ($data_by_city as $city) {
                            $sum += pow($city->total_deaths - $mean, 2);
                        }

                        $variance = round($sum / $counter, 2);

                        $standard_deviation = round(sqrt($variance), 2);

                    @endphp
                </div>
                <div>
                    <P>Total deaths = {{ $total }}</p>
                    <canvas id="deaths" width="200" height="100"></canvas>
                    <p>Deaths mean (µ) = {{ $mean }}</p>
                    <p>Deaths variance (σ<sup>2</sup>) = {{ $variance }}</p>
                    <P>Deaths standard deviation (σ) = {{ $standard_deviation }}</P>
                </div>
            @elseif(isset($data_by_hospital))
                <h1>{{ $report_title }}</h1>
                <div class="tbl-header">
                    <table>
                        <tr>
                            <th>Hospital name</th>
                            <th>City</th>
                            <th>Total deaths</th>
                            <th>Available beds</th>
                        </tr>
                    </table>
                </div>
                <div class="tbl-content">
                    <table>
                        @foreach ($data_by_hospital as $hospital)
                            <tr>
                                <td>{{ $hospital->name }}</td>
                                <td>{{ $hospital->city }}</td>
                                <td>{{ $hospital->total_deaths }}</td>
                                <td>{{ $hospital->avail_beds }}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            @elseif(isset($data_by_date))
                <h1>{{ $report_title }}</h1>
                <div class="tbl-header">
                    <table>
                        <tr>
                            <th colspan="2">Total number of deaths starting from {{ $date }} until now</th>
                        </tr>
                        <tr>
                            <th>Date</th>
                            <th>Total deaths</th>
                        </tr>
                    </table>
                </div>
                <div class="tbl-content">
                    <table>
                        @foreach ($data_by_date as $date)
                            <tr>
                                <td>{{ $date->infection_date }}</td>
                                <td>{{ $date->total_deaths }}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            @elseif(isset($data_by_age))
                <h1>{{ $report_title }}</h1>
                <div class="tbl-header">
                    <table>
                        <tr>
                            <th>Age segment</th>
                            <th>Number of males</th>
                            <th>Male percentage</th>
                            <th>Number of females</th>
                            <th>Female percentage</th>
                            <th>Total deaths</th>
                        </tr>
                    </table>
                </div>
                <div class="tbl-content">
                    <table>
                        @foreach ($data_by_age as $segment)
                            <tr>
                                <td>{{ $segment->Age }}</td>
                                <td>{{ $segment->Male }}</td>
                                <td>{{ $segment->male_pcnt }}</td>
                                <td>{{ $segment->Female }}</td>
                                <td>{{ $segment->female_pcnt }}</td>
                                <td>{{ $segment->Total }}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            @endif
        </div>
    </div>
    @if (isset($data_by_city))
        <script>
            const canvas = document.getElementById('deaths').getContext('2d');

            let xlabels = [];

            @foreach ($data_by_city as $city)
                xlabels.push('{{ $city->city }}');
            @endforeach

            let ylabels = [];

            @foreach ($data_by_city as $city)
                ylabels.push('{{ $city->total_deaths }}');
            @endforeach

            let data = {
                labels: xlabels,
                datasets: [{
                    label: 'Deaths count',
                    backgroundColor: 'rgb(255, 99, 132)',
                    borderColor: 'rgb(255, 99, 132)',
                    data: ylabels
                }]
            };

            let config = {
                type: 'bar',
                data: data
            };
            new Chart(canvas, config);
        </script>
    @endif
    <script src="{{ asset('js/statistics.js') }}"></script>
</x-app-layout>
