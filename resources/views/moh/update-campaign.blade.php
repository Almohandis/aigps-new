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

                <hr>

                <input type="submit" value="Update" class="add-doc-btn mt-5">
            </form>

            <form action="/staff/moh/manage-campaigns/{{$campaign->id}}/doctors/add"method="POST">
                @csrf
                <h1 class="mt-5 text-2xl">Campaign Doctors:</h1><br>

                <label for="national_id">Add doctor: </label>
                <x-input oninput="validateNid(this)" type="text" name="national_id" placeholder="National ID" required></x-input>

                <script>
                    function validateNid(input) {
                        if (input.value.length != 14 || isNaN(input.value) || !(input.value[0] == '2' || input.value[0] == '1' || input.value[0] == '3')) {
                            input.style.outline = "red solid thin";
                        } else {
                            input.style.outline = "green solid thin";
                        }
                    }
                </script>

                <input type="submit" value="Add" class="add-doc-btn mt-5">

                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">National ID</th>
                            <th scope="col">Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($campaign->doctors as $id => $doctor)
                            <tr>
                                <td>{{ $id + 1 }}</td>
                                <td>{{$doctor->name}}</td>
                                <td>{{$doctor->national_id}}</td>
                                <td><a href="/staff/moh/manage-campaigns/{{$campaign->id}}/doctors/{{$doctor->id}}/remove" class="text-red-500">Remove</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </form>
        </div>
    </div>
    <script src="{{ asset('js/manage-campaigns.js') }}"></script>
</x-app-layout>
