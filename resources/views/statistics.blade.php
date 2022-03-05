<x-app-layout>
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 mt-9">
        <div class="notification">
            @if (session('message'))
                {{ session('message') }}
            @endif
        </div>
        <div class="pt-8 sm:pt-0">
            <h1>All upcoming campaigns</h1><br>
            <form action="/stats" method="POST">
                @csrf
                <select name="report_name" id="">
                    <option value="" disabled hidden selected>Please choose a report name</option>

                </select>
            </form>
        </div>
    </div>
    <script src="{{ asset('js/statistics.js') }}"></script>
</x-app-layout>
