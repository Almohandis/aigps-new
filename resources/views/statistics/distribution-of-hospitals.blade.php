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
                <div class="tbl-header">
                    <table>
                        <tr>
                            <th>City</th>
                            <th>Available beds</th>
                            <th>Total hospitals</th>
                            <th>Isolation hospitals</th>
                            <th>Total hospitalizations</th>
                        </tr>
                    </table>
                </div>
                <div class="tbl-content">
                    <table>
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
                <table>
                    <tr>
                        <th>Hospital name</th>
                        <th>City</th>
                        <th>Is isolation</th>
                        <th>Capacity</th>
                        <th>Available beds</th>
                    </tr>
                    @foreach ($data_by_hospital as $hospital)
                        <tr>
                            <td>{{ $hospital->name }}</td>
                            <td>{{ $hospital->city }}</td>
                            <td>{{ $hospital->is_iso }}</td>
                            <td>{{ $hospital->capacity }}</td>
                            <td>{{ $hospital->avail_beds }}</td>
                        </tr>
                    @endforeach
                </table>
            @endif
        </div>
    </div>
    <script src="{{ asset('js/statistics.js') }}"></script>
</x-app-layout>
