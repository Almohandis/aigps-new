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
                            <th>Number of males</th>
                            <th>Males percentage</th>
                            <th>Number of females</th>
                            <th>Females percentage</th>
                            <th>Total number of infections</th>
                            <th>Total hospitals</th>
                            <th>Average available beds</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($data_by_city as $city)
                            <tr>
                                <td>{{ $city->city }}</td>
                                <td>{{ $city->male_count }}</td>
                                <td>{{ $city->male_pcnt }}</td>
                                <td>{{ $city->female_count }}</td>
                                <td>{{ $city->female_pcnt }}</td>
                                <td>{{ $city->total_infections }}</td>
                                <td>{{ $city->tot_hos }}</td>
                                <td>{{ $city->avg_avail_beds }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div>
                    @php
                        $counter = count($data_by_city);
                        $sum = 0;
                        $mean = 0;
                        $variance = 0;
                        $standard_deviation = 0;

                        foreach ($data_by_city as $city) {
                            $sum += $city->total_infections;
                        }

                        $mean = round($sum / $counter, 2);

                        $total = $sum;
                        $sum = 0;

                        foreach ($data_by_city as $city) {
                            $sum += pow($city->total_infections - $mean, 2);
                        }

                        $variance = round($sum / $counter, 2);

                        $standard_deviation = round(sqrt($variance), 2);

                    @endphp
                </div>
                <div>
                    <P>Total infections = {{ $total }}</p>
                    <canvas id="infections" width="200" height="100"></canvas>
                    <div class="alert alert-info mt-5">
                        <p>Infections mean (µ) = {{ $mean }}</p>
                        <p>Infections variance (σ<sup>2</sup>) = {{ $variance }}</p>
                        <P>Infections standard deviation (σ) = {{ $standard_deviation }}</P>
                    </div>
                </div>
            @elseif(isset($data_by_vaccine_status))
                <h1>{{ $report_title }}</h1>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Vaccine status</th>
                            <th>Number of males</th>
                            <th>Males percentage</th>
                            <th>Number of females</th>
                            <th>Female percentage</th>
                            <th>Total number of infections</th>
                        </tr>
                    </thead>

                    <tbody>
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
                    </tbody>
                </table>
            @elseif(isset($data_by_date))
                <h1>{{ $report_title }}</h1>
                <table class="table table-hover">
                    <thead>
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
                    </thead>

                    <tbody>
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
                            <th>Total infections</th>
                        </tr>
                    </thead>
                    @php
                        $second = $data_by_age[1];
                        $data_by_age[1] = $data_by_age[2];
                        $data_by_age[2] = $second;
                    @endphp
                    <tbody>
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
                    </tbody>
                </table>
                <div>
                    @php
                        $counter = count($data_by_age);
                        $sum = 0;
                        $mean = 0;
                        $variance = 0;
                        $standard_deviation = 0;

                        foreach ($data_by_age as $age) {
                            $sum += $age->total;
                        }

                        $mean = round($sum / $counter, 2);

                        $total = $sum;
                        $sum = 0;

                        foreach ($data_by_age as $age) {
                            $sum += pow($age->total - $mean, 2);
                        }

                        $variance = round($sum / $counter, 2);

                        $standard_deviation = round(sqrt($variance), 2);

                    @endphp
                </div>
                <div>
                    <P>Total infections = {{ $total }}</p>
                    <canvas id="infections" width="200" height="100"></canvas>
                    <div class="alert alert-info mt-5">
                        <p>Infections mean (µ) = {{ $mean }}</p>
                        <p>Infections variance (σ<sup>2</sup>) = {{ $variance }}</p>
                        <P>Infections standard deviation (σ) = {{ $standard_deviation }}</P>
                    </div>
                </div>
            @endif
        </div>
        @if (isset($data_by_city))
            <div class="mx-auto text-center mt-5">
                <div id="map" style="width: 100%; height: 500px;" class="aigps-map mb-5"></div>
                <div id="legend">
                    <h5>Legend</h5>
                    <canvas width="15" height="15" id="legend1"></canvas>
                </div>

                <script src="https://maps.googleapis.com/maps/api/js?key={{ config('app.google_maps_api') }}&callback=initMap" defer>
                </script>

                <script>
                    function initMap() {

                        let cities = [
                            @foreach ($cities as $city)
                                {
                                    name: "{{ $city->city }}",
                                    center: {
                                        lat: {{ $city->lat }},
                                        lng: {{ $city->lng }}
                                    },

                                    population: {{ ($city->total * 100) / $max / 100 }}
                                },
                            @endforeach
                        ];



                        var map = new google.maps.Map(document.getElementById('map'), {
                            mapId: "dcba2c77acce5e73",
                            zoom: 6,
                            center: new google.maps.LatLng(26.8206, 30.8025)
                        });


                        cities.forEach(function(city) {
                            const cityCircle = new google.maps.Circle({
                                strokeColor: "#FF1111",
                                strokeOpacity: Math.max(city.population, 0.7) + 0.1,
                                strokeWeight: 2,
                                fillColor: "#FF0000",
                                fillOpacity: Math.max(0.09, Math.min(city.population, 0.5)),
                                map,
                                center: city.center,
                                radius: 30000,
                            });
                        });

                        //# Map legend
                        const legend = document.getElementById("legend");

                        var c = document.getElementById("legend1");
                        var ctx = c.getContext("2d");
                        ctx.beginPath();
                        ctx.arc(7.5, 7.5, 7.5, 0, 2 * Math.PI);
                        ctx.strokeStyle = "#FF0000";
                        ctx.fillStyle = "#eb6b34";
                        ctx.fill();
                        ctx.stroke();

                        const div = document.createElement("div");
                        div.className = "text-start";
                        div.innerHTML = "Infections";
                        div.style.display = "inline-block";
                        div.style.fontSize = "15px";
                        div.style.lineHeight = "15px";
                        legend.appendChild(div);

                        map.controls[google.maps.ControlPosition.LEFT_BOTTOM].push(legend);

                    }
                </script>
            </div>
        @endif

    </div>
    @if (isset($data_by_city))
        <script>
            const canvas = document.getElementById('infections').getContext('2d');

            let xlabels = [];

            @foreach ($data_by_city as $city)
                xlabels.push('{{ $city->city }}');
            @endforeach

            let ylabels = [];

            @foreach ($data_by_city as $city)
                ylabels.push('{{ $city->total_infections }}');
            @endforeach

            let data = {
                labels: xlabels,
                datasets: [{
                    label: 'Infections count',
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
    @elseif(isset($data_by_age))
        <script>
            const canvas = document.getElementById('infections').getContext('2d');

            let xlabels = [];

            @foreach ($data_by_age as $age)
                xlabels.push('{{ $age->age }}');
            @endforeach

            let ylabels = [];

            @foreach ($data_by_age as $age)
                ylabels.push('{{ $age->total }}');
            @endforeach

            let data = {
                labels: xlabels,
                datasets: [{
                    label: 'Infections count',
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
