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
                <th>
                <td>#</td>
                <td>Start date</td>
                <td>End date</td>
                <td>Address</td>
                </th>
                @foreach ($campaigns as $campaign)
                    <tr>
                        <td>{{ $campaign->id }}</td>
                        <td>{{ $campaign->start_date }}</td>
                        <td>{{ $campaign->end_date }}</td>
                        <td>{{ $campaign->address }}</td>
                        @if ($campaign->status == 'active')
                            <td><input type="button" value="Undo escorting" class='buttons'
                                    data-id="{{ $campaign->id }}"></td>
                        @else
                            <td><input type="button" value="Escort" class='buttons' data-id="{{ $campaign->id }}"></td>
                        @endif
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
    <script src="{{ asset('js/escorting.js') }}"></script>
</x-app-layout>
