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
            @if (isset($data_by_vaccine_status))
                <table>
                    <tr>
                        <th>Vaccine status category</th>
                        <th>Number of males</th>
                        <th>Male percentage</th>
                        <th>Number of female</th>
                        <th>Female percentage</th>
                        <th>Total</th>
                    </tr>
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
                </table>
            @endif
        </div>
    </div>
    <script src="{{ asset('js/statistics.js') }}"></script>
</x-app-layout>
