<x-app-layout>
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 mt-9">
        <div class="notification">
            @if (session('message'))
                {{ session('message') }}
            @endif
        </div>
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
                            <th>Total doctors</th>
                            <th>Number of hospitals</th>
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
                                        <td>{{ $data_by_city[$j]->total_doctors }}</td>
                                        <td>{{ $data_by_city[$j]->num_hospitals }}</td>
                                        @php $j++ @endphp
                                    @else
                                        <td>0</td>
                                        <td>0</td>
                                    @endif
                                @else
                                    <td>0</td>
                                    <td>0</td>
                                @endif
                            </tr>
                        @endfor
                    </table>
                </div>
            @elseif(isset($data_by_hospital))
                <h1>{{ $report_title }}</h1>
                <div class="tbl-header">
                    <table>
                        <tr>
                            <th>Hospital name</th>
                            <th>City</th>
                            <th>Number of doctors</th>
                            <th>Is isolation</th>
                        </tr>
                    </table>
                </div>
                <div class="tbl-content">
                    <table>
                        @foreach ($data_by_hospital as $hospital)
                            <tr>
                                <td>{{ $hospital->name }}</td>
                                <td>{{ $hospital->city }}</td>
                                <td>{{ $hospital->num_doctors }}</td>
                                <td>{{ $hospital->is_iso }}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            @endif
        </div>
    </div>
    <script src="{{ asset('js/statistics.js') }}"></script>
</x-app-layout>
