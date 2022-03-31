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
            @if (isset($data_by_vaccine_status))
                <h1>{{ $report_title }}</h1>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Vaccine status category</th>
                            <th>Total</th>
                        </tr>
                    </thead>
               
                    <tbody>
                        @foreach ($data_by_vaccine_status as $status)
                            <tr>
                                <td>{{ $status->vac_status }}</td>
                                <td>{{ $status->Total }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div>
                    <canvas id="vaccine" width="200" height="100"></canvas>
                </div>
            @endif
        </div>
    </div>
    @if (isset($data_by_vaccine_status))
        <script>
            const canvas = document.getElementById('vaccine').getContext('2d');

            let xlabels = [];

            @foreach ($data_by_vaccine_status as $status)
                xlabels.push('{{ $status->vac_status }}');
            @endforeach

            let ylabels = [];

            @foreach ($data_by_vaccine_status as $status)
                ylabels.push('{{ $status->Total }}');
            @endforeach

            let data = {
                labels: xlabels,
                datasets: [{
                    label: 'Persons count',
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
