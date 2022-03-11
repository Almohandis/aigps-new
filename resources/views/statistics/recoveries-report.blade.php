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
                            @if ($cities[$i] == $data_by_city[$j]->city)
                                <td>{{ $data_by_city[$j]->total_recoveries }}</td>
                                <td>{{ $data_by_city[$j]->total_hospitals }}</td>
                                <td>{{ $data_by_city[$j]->average_available_beds }}</td>
                                @php $j++ @endphp
                            @else
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                            @endif
                        </tr>
                    @endfor
                </table>
            @elseif(isset($data_by_age))
            @endif
        </div>
    </div>
    <script src="{{ asset('js/statistics.js') }}"></script>
</x-app-layout>
