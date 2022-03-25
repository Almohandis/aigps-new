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
            @if (isset($data_by_personal))
                <h1>{{ $report_title }}</h1>
                <div class="tbl-header">
                    <table>
                        <tr>
                            <th>#</th>
                            <th>Infection date</th>
                            <th>Hospital name</th>
                            <th>City</th>
                            <th>Recovery status</th>
                        </tr>
                    </table>
                </div>
                <div class="tbl-content">
                    <table>
                        @php $i=1; @endphp
                        @foreach ($data_by_personal as $infection)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $infection->infection_date }}</td>
                                <td>{{ $infection->name }}</td>
                                <td>{{ $infection->city }}</td>
                                <td>{{ $infection->is_recovered ? 'Recovered' : 'Not recovered' }}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            @endif
        </div>
    </div>
    <script src="{{ asset('js/statistics.js') }}"></script>
</x-app-layout>
