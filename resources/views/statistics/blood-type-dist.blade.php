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
                            <th>A+</th>
                            <th>A-</th>
                            <th>B+</th>
                            <th>B-</th>
                            <th>AB+</th>
                            <th>AB-</th>
                            <th>O+</th>
                            <th>O-</th>
                        </tr>
                    </table>
                </div>
                <div class="tbl-content">
                    <table>
                        @foreach ($data_by_city as $city)
                            <tr>
                                <td>{{ $city->city }}</td>
                                <td>{{ $city->A_plus }}</td>
                                <td>{{ $city->A_minus }}</td>
                                <td>{{ $city->B_plus }}</td>
                                <td>{{ $city->B_minus }}</td>
                                <td>{{ $city->AB_plus }}</td>
                                <td>{{ $city->AB_minus }}</td>
                                <td>{{ $city->O_plus }}</td>
                                <td>{{ $city->O_minus }}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
                <div>
                    @php
                        $counters = array_fill(0, 8, 0);
                        $sums = array_fill(0, 8, 0);
                        $means = array_fill(0, 8, 0);
                        $variances = array_fill(0, 8, 0);
                        $standard_deviations = array_fill(0, 8, 0);
                        foreach ($data_by_city as $city) {
                            if ($city->A_plus != 0) {
                                $counters[0]++;
                            }
                            if ($city->A_minus != 0) {
                                $counters[1]++;
                            }
                            if ($city->B_plus != 0) {
                                $counters[2]++;
                            }
                            if ($city->B_minus != 0) {
                                $counters[3]++;
                            }
                            if ($city->AB_plus != 0) {
                                $counters[4]++;
                            }
                            if ($city->AB_minus != 0) {
                                $counters[5]++;
                            }
                            if ($city->O_plus != 0) {
                                $counters[6]++;
                            }
                            if ($city->O_minus != 0) {
                                $counters[7]++;
                            }
                        }
                        $means[0] = $counters[0] ? round($total_count->tot_a_plus / $counters[0], 2) : 0;
                        $means[1] = $counters[1] ? round($total_count->tot_a_minus / $counters[1], 2) : 0;
                        $means[2] = $counters[2] ? round($total_count->tot_b_plus / $counters[2], 2) : 0;
                        $means[3] = $counters[3] ? round($total_count->tot_b_minus / $counters[3], 2) : 0;
                        $means[4] = $counters[4] ? round($total_count->tot_ab_plus / $counters[4], 2) : 0;
                        $means[5] = $counters[5] ? round($total_count->tot_ab_minus / $counters[5], 2) : 0;
                        $means[6] = $counters[6] ? round($total_count->tot_o_plus / $counters[6], 2) : 0;
                        $means[7] = $counters[7] ? round($total_count->tot_o_minus / $counters[7], 2) : 0;

                        foreach ($data_by_city as $city) {
                            if ($city->A_plus != 0) {
                                $sums[0] += pow($city->A_plus - $means[0], 2);
                            }
                            if ($city->A_minus != 0) {
                                $sums[1] += pow($city->A_minus - $means[1], 2);
                            }
                            if ($city->B_plus != 0) {
                                $sums[2] += pow($city->B_plus - $means[2], 2);
                            }
                            if ($city->B_minus != 0) {
                                $sums[3] += pow($city->B_minus - $means[3], 2);
                            }
                            if ($city->AB_plus != 0) {
                                $sums[4] += pow($city->AB_plus - $means[4], 2);
                            }
                            if ($city->AB_minus != 0) {
                                $sums[5] += pow($city->AB_minus - $means[5], 2);
                            }
                            if ($city->O_plus != 0) {
                                $sums[6] += pow($city->O_plus - $means[6], 2);
                            }
                            if ($city->O_minus != 0) {
                                $sums[7] += pow($city->O_minus - $means[7], 2);
                            }
                        }
                        for ($i = 0; $i < 8; $i++) {
                            $variances[$i] = $counters[$i] ? round($sums[$i] / $counters[$i], 2) : 0;
                        }
                        for ($i = 0; $i < 8; $i++) {
                            $standard_deviations[$i] = round(sqrt($variances[$i]), 2);
                        }
                    @endphp
                </div>
                <div>
                    <P>Total A+ count = {{ $total_count->tot_a_plus }}</P>
                    <canvas id="a-plus" width="200" height="100"></canvas>
                    <p>A+ mean (µ) = {{ $means[0] }}</p>
                    <p>A+ variance (σ<sup>2</sup>) = {{ $variances[0] }}</p>
                    <P>A+ standard deviation (σ) = {{ $standard_deviations[0] }}</P>
                </div>
                <div>
                    <P>Total A- count = {{ $total_count->tot_a_minus }}</P>
                    <canvas id="a-minus" width="200" height="100"></canvas>
                    <p>A- mean (µ) = {{ $means[1] }}</p>
                    <p>A- variance (σ<sup>2</sup>) = {{ $variances[1] }}</p>
                    <P>A- standard deviation (σ) = {{ $standard_deviations[1] }}</P>
                </div>
                <div>
                    <P>Total B+ count = {{ $total_count->tot_b_plus }}</P>
                    <canvas id="b-plus" width="200" height="100"></canvas>
                    <p>B+ mean (µ) = {{ $means[2] }}</p>
                    <p>B+ variance (σ<sup>2</sup>) = {{ $variances[2] }}</p>
                    <P>B+ standard deviation (σ) = {{ $standard_deviations[2] }}</P>
                </div>
                <div>
                    <P>Total B- count = {{ $total_count->tot_b_minus }}</P>
                    <canvas id="b-minus" width="200" height="100"></canvas>
                    <p>B- mean (µ) = {{ $means[3] }}</p>
                    <p>B- variance (σ<sup>2</sup>) = {{ $variances[3] }}</p>
                    <P>B- standard deviation (σ) = {{ $standard_deviations[3] }}</P>
                </div>
                <div>
                    <P>Total AB+ count = {{ $total_count->tot_ab_plus }}</P>
                    <canvas id="ab-plus" width="200" height="100"></canvas>
                    <p>AB+ mean (µ) = {{ $means[4] }}</p>
                    <p>AB+ variance (σ<sup>2</sup>) = {{ $variances[4] }}</p>
                    <P>AB+ standard deviation (σ) = {{ $standard_deviations[4] }}</P>
                </div>
                <div>
                    <P>Total AB- count = {{ $total_count->tot_ab_minus }}</P>
                    <canvas id="ab-minus" width="200" height="100"></canvas>
                    <p>AB- mean (µ) = {{ $means[5] }}</p>
                    <p>AB- variance (σ<sup>2</sup>) = {{ $variances[5] }}</p>
                    <P>AB- standard deviation (σ) = {{ $standard_deviations[5] }}</P>
                </div>
                <div>
                    <P>Total O+ count = {{ $total_count->tot_o_plus }}</P>
                    <canvas id="o-plus" width="200" height="100"></canvas>
                    <p>O+ mean (µ) = {{ $means[6] }}</p>
                    <p>O+ variance (σ<sup>2</sup>) = {{ $variances[6] }}</p>
                    <P>O+ standard deviation (σ) = {{ $standard_deviations[6] }}</P>
                </div>
                <div>
                    <P>Total O- count = {{ $total_count->tot_o_minus }}</P>
                    <canvas id="o-minus" width="200" height="100"></canvas>
                    <p>O- mean (µ) = {{ $means[7] }}</p>
                    <p>O- variance (σ<sup>2</sup>) = {{ $variances[7] }}</p>
                    <P>O- standard deviation (σ) = {{ $standard_deviations[7] }}</P>
                </div>
            @elseif(isset($data_by_age))
                <h1>{{ $report_title }}</h1>
                <div class="tbl-header">
                    <table>
                        <tr>
                            <th>Age segment</th>
                            <th>A+</th>
                            <th>A-</th>
                            <th>B+</th>
                            <th>B-</th>
                            <th>AB+</th>
                            <th>AB-</th>
                            <th>O+</th>
                            <th>O-</th>
                        </tr>
                    </table>
                </div>
                <div class="tbl-content">
                    <table>
                        @foreach ($data_by_age as $age)
                            <tr>
                                <td>{{ $age->age }}</td>
                                <td>{{ $age->A_plus }}</td>
                                <td>{{ $age->A_minus }}</td>
                                <td>{{ $age->B_plus }}</td>
                                <td>{{ $age->B_minus }}</td>
                                <td>{{ $age->AB_plus }}</td>
                                <td>{{ $age->AB_minus }}</td>
                                <td>{{ $age->O_plus }}</td>
                                <td>{{ $age->O_minus }}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
                <div>
                    @php
                        $counters = array_fill(0, count($data_by_age), 8);
                        $sums = array_fill(0, count($data_by_age), 0);
                        $means = array_fill(0, count($data_by_age), 0);
                        $variances = array_fill(0, count($data_by_age), 0);
                        $standard_deviations = array_fill(0, count($data_by_age), 0);

                        for ($i = 0; $i < count($counters); $i++) {
                            foreach ($data_by_age[$i] as $key => $blood_type) {
                                if (is_numeric($blood_type) && $key != 'total') {
                                    $sums[$i] += $blood_type;
                                }
                            }
                        }

                        for ($i = 0; $i < count($counters); $i++) {
                            $means[$i] = round($sums[$i] / $counters[$i], 2);
                        }

                        $sums = array_fill(0, count($data_by_age), 0);

                        for ($i = 0; $i < count($counters); $i++) {
                            foreach ($data_by_age[$i] as $key => $blood_type) {
                                if (is_numeric($blood_type) && $key != 'total') {
                                    $sums[$i] += pow($blood_type - $means[$i], 2);
                                }
                            }
                        }

                        for ($i = 0; $i < count($counters); $i++) {
                            $variances[$i] = round($sums[$i] / $counters[$i], 2);
                        }

                        for ($i = 0; $i < count($counters); $i++) {
                            $standard_deviations[$i] = round(sqrt($variances[$i]), 2);
                        }
                    @endphp
                </div>
                <div>
                    @for ($i = 0; $i < count($counters); $i++)
                        <P>Total {{ $data_by_age[$i]->age }} = {{ $data_by_age[$i]->total }}</p>
                        <canvas id="{{ $age->age }}" width="200" height="100"></canvas>
                        <p>{{ $data_by_age[$i]->age }} mean (µ) = {{ $means[$i] }}</p>
                        <p>{{ $data_by_age[$i]->age }} variance (σ<sup>2</sup>) = {{ $variances[$i] }}</p>
                        <P>{{ $data_by_age[$i]->age }} standard deviation (σ) = {{ $standard_deviations[$i] }}</P>
                    @endfor

                </div>
            @elseif(isset($data_by_blood))
                <h1>{{ $report_title }}</h1>
                <div class="tbl-header">
                    <table>
                        <tr>
                            <th>Blood type</th>
                            <th>Total persons from this type</th>
                            <th>Percentage of this type</th>
                            <th>Male percentage</th>
                            <th>Female percentage</th>
                        </tr>
                    </table>
                </div>
                <div class="tbl-content">
                    <table>
                        @for ($i = 0; $i < count($data_by_blood); $i++)
                            <tr>
                                @foreach ($data_by_blood[$i] as $item)
                                    <td>{{ $item }}</td>
                                @endforeach
                            </tr>
                        @endfor
                    </table>
                </div>
                <div>
                    @php
                        $counter = count($data_by_blood);
                        $sum = 0;
                        $mean = 0;
                        $variance = 0;
                        $standard_deviation = 0;
                        foreach ($data_by_blood as $blood) {
                            $sum += $blood->total_blood_type_count;
                        }
                        $mean = $counter ? round($sum / $counter, 2) : 0;
                        $sum = 0;
                        foreach ($data_by_blood as $blood) {
                            $sum += pow($blood->total_blood_type_count - $mean, 2);
                        }

                        $variance = $counter ? round($sum / $counter, 2) : 0;

                        $standard_deviation = round(sqrt($variance), 2);

                    @endphp
                </div>
                <div>
                    <P>Blood types count = {{ $counter }}</P>
                    <canvas id="total_blood" width="200" height="100"></canvas>
                    <p>Blood types mean (µ) = {{ $mean }}</p>
                    <p>Blood types variance (σ<sup>2</sup>) = {{ $variance }}</p>
                    <P>Blood types standard deviation (σ) = {{ $standard_deviation }}</P>
                </div>
            @endif
        </div>
    </div>
    @if (isset($data_by_city))
        <script>
            const a_plus = document.getElementById('a-plus').getContext('2d');
            const a_minus = document.getElementById('a-minus').getContext('2d');
            const b_plus = document.getElementById('b-plus').getContext('2d');
            const b_minus = document.getElementById('b-minus').getContext('2d');
            const ab_plus = document.getElementById('ab-plus').getContext('2d');
            const ab_minus = document.getElementById('ab-minus').getContext('2d');
            const o_plus = document.getElementById('o-plus').getContext('2d');
            const o_minus = document.getElementById('o-minus').getContext('2d');

            let xlabels = [];
            @foreach ($data_by_city as $city)
                {
                xlabels.push("{{ $city->city }}");
                }
            @endforeach

            // A+
            let ylabels_a_plus = [];
            @foreach ($data_by_city as $city)
                {
                ylabels_a_plus.push("{{ $city->A_plus }}");
                }
            @endforeach

            const data_a_plus = {
                labels: xlabels,
                datasets: [{
                    label: 'A+ count',
                    backgroundColor: 'rgb(255, 99, 132)',
                    borderColor: 'rgb(255, 99, 132)',
                    data: ylabels_a_plus,
                }]
            }

            const config_a_plus = {
                type: 'bar',
                data: data_a_plus
            };
            new Chart(a_plus, config_a_plus);
            ////////////////////////////////

            // A-
            let ylabels_a_minus = [];
            @foreach ($data_by_city as $city)
                {
                ylabels_a_minus.push("{{ $city->A_minus }}");
                }
            @endforeach

            const data_a_minus = {
                labels: xlabels,
                datasets: [{
                    label: 'A- count',
                    backgroundColor: 'rgb(255, 99, 132)',
                    borderColor: 'rgb(255, 99, 132)',
                    data: ylabels_a_minus,
                }]
            }

            const config_a_minus = {
                type: 'bar',
                data: data_a_minus
            };
            new Chart(a_minus, config_a_minus);
            ////////////////////////////////

            // B+
            let ylabels_b_plus = [];
            @foreach ($data_by_city as $city)
                {
                ylabels_b_plus.push("{{ $city->B_plus }}");
                }
            @endforeach

            const data_b_plus = {
                labels: xlabels,
                datasets: [{
                    label: 'B+ count',
                    backgroundColor: 'rgb(255, 99, 132)',
                    borderColor: 'rgb(255, 99, 132)',
                    data: ylabels_b_plus,
                }]
            }

            const config_b_plus = {
                type: 'bar',
                data: data_b_plus
            };
            new Chart(b_plus, config_b_plus);
            ////////////////////////////////

            // B-
            let ylabels_b_minus = [];
            @foreach ($data_by_city as $city)
                {
                ylabels_b_minus.push("{{ $city->B_minus }}");
                }
            @endforeach

            const data_b_minus = {
                labels: xlabels,
                datasets: [{
                    label: 'B- count',
                    backgroundColor: 'rgb(255, 99, 132)',
                    borderColor: 'rgb(255, 99, 132)',
                    data: ylabels_b_minus,
                }]
            }

            const config_b_minus = {
                type: 'bar',
                data: data_b_minus
            };
            new Chart(b_minus, config_b_minus);
            ////////////////////////////////

            // AB+
            let ylabels_ab_plus = [];
            @foreach ($data_by_city as $city)
                {
                ylabels_ab_plus.push("{{ $city->AB_plus }}");
                }
            @endforeach

            const data_ab_plus = {
                labels: xlabels,
                datasets: [{
                    label: 'AB+ count',
                    backgroundColor: 'rgb(255, 99, 132)',
                    borderColor: 'rgb(255, 99, 132)',
                    data: ylabels_ab_plus,
                }]
            }

            const config_ab_plus = {
                type: 'bar',
                data: data_ab_plus
            };
            new Chart(ab_plus, config_ab_plus);
            ////////////////////////////////

            // AB-
            let ylabels_ab_minus = [];
            @foreach ($data_by_city as $city)
                {
                ylabels_ab_minus.push("{{ $city->AB_minus }}");
                }
            @endforeach

            const data_ab_minus = {
                labels: xlabels,
                datasets: [{
                    label: 'AB- count',
                    backgroundColor: 'rgb(255, 99, 132)',
                    borderColor: 'rgb(255, 99, 132)',
                    data: ylabels_ab_minus,
                }]
            }

            const config_ab_minus = {
                type: 'bar',
                data: data_ab_minus
            };
            new Chart(ab_minus, config_ab_minus);
            ////////////////////////////////

            // O+
            let ylabels_o_plus = [];
            @foreach ($data_by_city as $city)
                {
                ylabels_o_plus.push("{{ $city->O_plus }}");
                }
            @endforeach

            const data_o_plus = {
                labels: xlabels,
                datasets: [{
                    label: 'O+ count',
                    backgroundColor: 'rgb(255, 99, 132)',
                    borderColor: 'rgb(255, 99, 132)',
                    data: ylabels_o_plus,
                }]
            }

            const config_o_plus = {
                type: 'bar',
                data: data_o_plus
            };
            new Chart(o_plus, config_o_plus);
            ////////////////////////////////

            // O-
            let ylabels_o_minus = [];
            @foreach ($data_by_city as $city)
                {
                ylabels_o_minus.push("{{ $city->O_minus }}");
                }
            @endforeach

            const data_o_minus = {
                labels: xlabels,
                datasets: [{
                    label: 'O- count',
                    backgroundColor: 'rgb(255, 99, 132)',
                    borderColor: 'rgb(255, 99, 132)',
                    data: ylabels_o_minus,
                }]
            }

            const config_o_minus = {
                type: 'bar',
                data: data_o_minus
            };
            new Chart(o_minus, config_o_minus);
            ////////////////////////////////
        </script>
    @elseif(isset($data_by_blood))
        <script>
            const total_blood = document.getElementById('total_blood').getContext('2d');

            let xlabels = [];
            @foreach ($data_by_blood as $blood)
                {
                xlabels.push("{{ $blood->blood_type }}");
                }
            @endforeach

            // total blood
            let ylabels = [];
            @foreach ($data_by_blood as $blood)
                {
                ylabels.push("{{ $blood->total_blood_type_count }}");
                }
            @endforeach

            const data = {
                labels: xlabels,
                datasets: [{
                    label: 'Persons count',
                    backgroundColor: 'rgb(255, 99, 132)',
                    borderColor: 'rgb(255, 99, 132)',
                    data: ylabels,
                }]
            }

            const config = {
                type: 'bar',
                data: data
            };
            new Chart(total_blood, config);
        </script>
    @elseif(isset($data_by_age))
        <script>
            const canvases = document.querySelectorAll('canvas');

            let xlabels = ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'];

            // total blood
            let ylabels = [
                @foreach ($data_by_age as $age)
                    [
                    @foreach ($age as $key => $blood_type)
                        @if (is_numeric($blood_type) && $key != 'total')
                            "{{ $blood_type }}",
                        @endif
                    @endforeach
                    ],
                @endforeach
            ];

            let data_ = [];
            for (let i = 0; i < canvases.length; i++) {
                let temp = {
                    labels: xlabels,
                    datasets: [{
                        label: 'Persons count',
                        backgroundColor: 'rgb(255, 99, 132)',
                        borderColor: 'rgb(255, 99, 132)',
                        data: ylabels[i]
                    }]
                };
                data_.push(temp);
            }


            let config = [];
            for (let i = 0; i < canvases.length; i++) {
                let temp = {
                    type: 'bar',
                    data: data_[i]
                };
                config.push(temp);
            }

            for (let i = 0; i < canvases.length; i++) {
                new Chart(canvases[i].getContext('2d'), config[i]);
            }
        </script>
    @endif

    <script src="{{ asset('js/statistics.js') }}"></script>

</x-app-layout>
