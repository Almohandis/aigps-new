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
                <h4>Date: {{ date('M d, Y') }}</h4>
                <h4>Time: {{ date('h:i A') }}</h4>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>City</th>
                            <th>Total doctors</th>
                            <th>Number of hospitals</th>
                        </tr>
                    </thead>


                    <tbody>
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
                    </tbody>
                </table>
            @elseif(isset($data_by_hospital))
                <h1>{{ $report_title }}</h1>
                <h4>Date: {{ date('M d, Y') }}</h4>
                <h4>Time: {{ date('h:i A') }}</h4>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Hospital name</th>
                            <th>City</th>
                            <th>Number of doctors</th>
                            <th>Is isolation</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data_by_hospital as $hospital)
                            <tr>
                                <td>{{ $hospital->name }}</td>
                                <td>{{ $hospital->city }}</td>
                                <td>{{ $hospital->num_doctors }}</td>
                                <td>{{ $hospital->is_iso }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
    <script src="{{ asset('js/statistics.js') }}"></script>
</x-app-layout>
