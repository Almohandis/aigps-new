<x-app-layout>
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 mt-9">
        <div class="notification">
            @if (session('message'))
                {{ session('message') }}
            @endif
        </div>
        <div class="pt-8 sm:pt-0">
            <h1 class="add-hero2">Update Campaign (#{{$campaign->id}})</h1><br>
            <form method="POST">
                @csrf
                <label for="address">Address: </label>
                <x-input type="text" name="address" label="Address" value="{{$campaign->address}}" required></x-input>
                <br>

                <label for="location">Location: </label>
                <x-input type="text" name="location" label="Location" value="{{$campaign->location}}" required></x-input>
                <br>

                <label for="city">City: </label>
                    <select name="city" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        @foreach ($cities as $city)
                            <option value="{{ $city }}">{{ $city }}</option>
                        @endforeach
                    </select>
                <br>

                <label for="start_date">Start date: </label>
                <input type="date" name="start_date" label="Start date" value="{{$campaign->start_date}}" required></input>
                <br>

                <label for="end_date">End date: </label>
                <input type="date" name="end_date" label="End date" value="{{$campaign->end_date}}" required></input>
                <br>

                <label for="capacity_per_day">Capacity per day: </label>
                <x-input type="number" name="capacity_per_day" label="Capacity per day" value="{{$campaign->capacity_per_day}}" required></x-input>
                <br>

                <input type="submit" value="Update">
            </form>
        </div>
    </div>
    <script src="{{ asset('js/manage-campaigns.js') }}"></script>
</x-app-layout>
