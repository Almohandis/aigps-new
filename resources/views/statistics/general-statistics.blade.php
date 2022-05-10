<x-app-layout>
    <div class="table-responsive text-start shadow container bg-white mt-5 rounded px-5 py-3 text-dark">
        <div class="notification">
            @if (session('message'))
                {{ session('message') }}
            @endif
        </div>
        <div class="pt-8 sm:pt-0">
            <form id="form" action="/stats" method="POST">
                @csrf
                <select name="report_name" id="report-name" class="form-control">
                    <option disabled hidden selected>Please choose a report name</option>
                    @foreach ($names as $name)
                        <option value="{{ $name }}">{{ $name }}</option>
                    @endforeach
                </select>
                <select name="report_by" id="report-by" class="form-control"></select>
                <button type="submit" id="generate-btn" class="btn btn-primary">Generate report</button>
            </form>
            @if (isset($data_by_general))
                <h1>{{$report_title}}</h1>
               <div class="p-header"> <p>Total recoveries:</div> <div class="p-content">  {{ $data_by_general[0]->total_rec }}</div></p>
               <div class="p-header"><p>Total deaths:</div> <div class="p-content"> {{ $data_by_general[0]->total_deaths }}</p></div>
               <div class="p-header"><p>Diagnoses done: </div><div class="p-content">{{ $data_by_general[0]->total_diagnosed }}</p></div>
               <div class="p-header"><p>Unvaccinated:</div> <div class="p-content">{{ $data_by_general[0]->total_un_vac }}</p></div>
                <div class="p-header"><p>Partially vaccinated:</div><div class="p-content"> {{ $data_by_general[0]->total_part_vac }}</p></div>
                    <div class="p-header"><p>Fully vaccinated:</div> <div class="p-content">{{ $data_by_general[0]->total_full_vac }}</p></div>
            @endif
        </div>
    </div>
    <script src="{{ asset('js/statistics.js') }}"></script>
</x-app-layout>
