<x-app-layout>
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 mt-9">
        <div class="notification">
            @if (session('message'))
                {{ session('message') }}
            @endif
        </div>
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
            @if (isset($data_by_general))
                <p>Total recoveries: {{ $data_by_general[0]->total_rec }}</p>
                <p>Total deaths: {{ $data_by_general[0]->total_deaths }}</p>
                <p>Diagnoses done: {{ $data_by_general[0]->total_diagnosed }}</p>
                <p>Unvaccinated: {{ $data_by_general[0]->total_un_vac }}</p>
                <p>Partially vaccinated: {{ $data_by_general[0]->total_part_vac }}</p>
                <p>Fully vaccinated: {{ $data_by_general[0]->total_full_vac }}</p>
            @endif
        </div>
    </div>
    <script src="{{ asset('js/statistics.js') }}"></script>
</x-app-layout>
