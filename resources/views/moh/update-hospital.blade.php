<x-app-layout>
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 mt-9">
        <div class="notification">
            @if (session('message'))
                {{ session('message') }}
            @endif
        </div>
        <div class="pt-8 sm:pt-0">
            <h1 class="add-hero2">Update Hospital (#{{$hospital->id}})</h1><br>
            <form method="POST">
                @csrf
                <label for="address">Name: </label>
                <x-input type="text" name="name" label="Name" value="{{$hospital->name}}" required></x-input>
                <br>

                <label for="capacity">Capacity: </label>
                <x-input type="number" name="capacity" label="Capacity" value="{{$hospital->capacity}}" required></x-input>
                <br>

                <label for="city">City: </label>
                    <select name="city" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        @foreach ($cities as $city)
                            <option value="{{ $city }}">{{ $city }}</option>
                        @endforeach
                    </select>
                <br>

                <input type="checkbox" name="is_isolation">
                <label for="is_isolation">Is Isolation</label>
                <br>

                <input type="submit" value="Update" class="add-doc-btn mt-5">
            </form>
        </div>
    </div>
</x-app-layout>
