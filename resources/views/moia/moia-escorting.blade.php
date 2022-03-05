<x-app-layout>
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 mt-9">
        <div class="notification">
            @if (session('message'))
                {{ session('message') }}
            @endif
        </div>
        <div class="pt-8 sm:pt-0">
            <h1>All available campaigns</h1>
            <table>
                <tr>
                    <th>#</th>
                    <th>Start date</th>
                    <th>End date</th>
                    <th>Address</th>
                </tr>
                @foreach ($campaigns as $campaign)
                    <tr>
                        <td>{{ $campaign->id }}</td>
                        <td>{{ $campaign->start_date }}</td>
                        <td>{{ $campaign->end_date }}</td>
                        <td>{{ $campaign->address }}</td>
                        <td></td>

                    </tr>
                @endforeach
            </table>
        </div>
    </div>
</x-app-layout>
