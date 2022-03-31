<x-app-layout>
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
            @if (isset($data_by_chronic_disease))
                <h1>{{ $report_title }}</h1>
                <table class="table table-hover"\>
                    <thead>
                        <tr>
                            <th>Disease name</th>
                            <th>Male patients</th>
                            <th>Male percentage</th>
                            <th>Female patients</th>
                            <th>Female percentage</th>
                            <th>Total patients</th>
                        </tr>
                    </thead>
                
                
                    <tbody>
                        @foreach ($data_by_chronic_disease as $disease)
                            <tr>
                                <td>{{ $disease->name }}</td>
                                <td>{{ $disease->male }}</td>
                                <td>{{ $disease->male_pcnt }}</td>
                                <td>{{ $disease->female }}</td>
                                <td>{{ $disease->female_pcnt }}</td>
                                <td>{{ $disease->total }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div>
                    <canvas id="disease" width="200" height="100"></canvas>
                </div>
            @endif
        </div>
    </div>
    @if (isset($data_by_chronic_disease))
        <script>
            const canvas = document.getElementById('disease').getContext('2d');

            let xlabels = [];

            @foreach ($data_by_chronic_disease as $disease)
                xlabels.push('{{ $disease->name }}');
            @endforeach

            let ylabels = [];

            @foreach ($data_by_chronic_disease as $disease)
                ylabels.push('{{ $disease->total }}');
            @endforeach

            let data = {
                labels: xlabels,
                datasets: [{
                    label: 'Patients count',
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
