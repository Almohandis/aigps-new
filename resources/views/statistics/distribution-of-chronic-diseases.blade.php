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
            @if (isset($data_by_chronic_disease))
                <h1>{{ $report_title }}</h1>
                <div class="tbl-header">
                    <table>
                        <tr>
                            <th>Disease name</th>
                            <th>Male patients</th>
                            <th>Male percentage</th>
                            <th>Female patients</th>
                            <th>Female percentage</th>
                            <th>Total patients</th>
                        </tr>
                    </table>
                </div>
                <div class="tbl-content">
                    <table>
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
                    </table>
                </div>
            @endif
        </div>
    </div>
    <script src="{{ asset('js/statistics.js') }}"></script>
</x-app-layout>
