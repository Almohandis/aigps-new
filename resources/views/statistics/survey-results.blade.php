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
            @if (isset($data_by_question))
                <h1>{{ $report_title }}</h1>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Question title</th>
                            <th>Answered No</th>
                            <th>Answered Yes</th>
                        </tr>
                    </thead>

                    <tbody>
                        @for ($i = 0; $i < count($data_by_question); $i++)
                            <tr>
                                <td>{{ $data_by_question[$i]->title }}</td>
                                <td>{{ $data_by_question[$i]->no }}</td>
                                <td>{{ $data_by_question[$i]->yes }}</td>
                            </tr>
                        @endfor
                    </table>
                </div>
            @elseif(isset($data_by_age))

            @elseif(isset($data_by_blood))
            @endif
        </div>
    </div>
    <script src="{{ asset('js/statistics.js') }}"></script>
</x-app-layout>
