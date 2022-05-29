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
            @if (isset($data_by_general))
                <h1>{{ $report_title }}</h1>
                <h4>Date: {{ date('M d, Y') }}</h4>
                <h4>Time: {{ date('h:i A') }}</h4>
                <table class="table table-hover">
                    <tbody>
                        <tr>
                            <td>Total recoveries</td>
                            <td>{{ $data_by_general[0]->total_rec }}</td>
                        </tr>
                        <tr>
                            <td>New cases</td>
                            <td>{{ $data_by_general[0]->new_cases }}</td>
                        </tr>
                        <tr>
                            <td>Total deaths</td>
                            <td>{{ $data_by_general[0]->total_deaths }}</td>
                        </tr>
                        <tr>
                            <td>Unvaccinated</td>
                            <td>{{ $data_by_general[0]->total_un_vac }}</td>
                        </tr>
                        <tr>
                            <td>Partially vaccinated</td>
                            <td>{{ $data_by_general[0]->total_part_vac }}</td>
                        </tr>
                        <tr>
                            <td>Fully vaccinated</td>
                            <td>{{ $data_by_general[0]->total_full_vac }}</td>
                        </tr>
                    </tbody>
                </table>
            @endif
        </div>
    </div>
    <script src="{{ asset('js/statistics.js') }}"></script>
</x-app-layout>
