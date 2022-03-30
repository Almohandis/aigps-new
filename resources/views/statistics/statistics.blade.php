<x-app-layout>
    <div class="mt-5 text-center">
        <h1 class="aigps-title">Statistics</h1>

        <div class="text-start shadow container bg-white mt-5 rounded p-5 text-dark">
            <h5 class="text-center mb-3">Select statistics report</h5>

            <form id="form" action="/stats" method="POST" class="flex row">
                @csrf
                <select name="report_name" id="report-name" class="form-control col-4">
                    <option disabled hidden selected>Please choose a report name</option>

                    @foreach ($names as $name)
                        <option value="{{ $name }}">{{ $name }}</option>
                    @endforeach
                </select>
                <select name="report_by" id="report-by" class="form-control col-4"></select>
                <button type="submit" id="generate-btn" class="btn btn-primary col-4">Generate report</button>
            </form>

            <script src="{{ asset('js/statistics.js') }}"></script>
        </div>
    </div>
</x-app-layout>
