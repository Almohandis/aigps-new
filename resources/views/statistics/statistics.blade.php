<x-app-layout>
    <div class="mt-5 text-center">
        <h1 class="aigps-title">Statistics</h1>

        <div class="text-start shadow container bg-white mt-5 rounded p-5 text-dark">
            <h5 class="text-center mb-3">Select statistics report</h5>

            <form id="form" action="/stats" method="POST" class="row">
                @csrf
                <div class="col-12 col-md-6 mt-3">
                    <select name="report_name" id="report-name" class="form-control">
                        <option disabled hidden selected>Please choose a report name</option>

                        @foreach ($names as $name)
                            <option value="{{ $name }}">{{ $name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12 col-md-6 mt-3">
                    <select name="report_by" id="report-by" class="form-control"></select>
                </div>

                <div class="col-12 mt-3 row justify-content-center text-center">
                    <div>
                        <button type="submit" id="generate-btn" class="btn btn-primary">Generate report</button>
                    </div>
                </div>
            </form>

            <script src="{{ asset('js/statistics.js') }}"></script>
        </div>
    </div>
</x-app-layout>
