<x-app-layout>
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 mt-9">
        <div class="notification">
            @if (session('message'))
                {{ session('message') }}
            @endif
        </div>
        <div class="pt-8 sm:pt-0">

            <div class="add-hospital">
                <h1 class="add-hero">Add new hospital</h1>
                <form action="/staff/moh/manage-hospitals/add" method="POST">
                    @csrf
                    <div style="margin-top: 2rem;margin-left: 4rem;">
                        <label for="hospital">Hospital name</label>
                        <input required type="text" name="name">
                    </div>
                    <div style="margin-left: 42rem;  margin-top: -2.5rem;">
                        <label for="city">City</label>
                        <select required name="city" id="city">
                            <option value="" hidden selected disabled>Select city</option>
                            @foreach ($cities as $city)
                                <option value="{{ $city }}">{{ $city }}</option>
                            @endforeach
                        </select>
                    </div><br>
                    <label for="capacity" style="margin-left: 6.5rem;">Capacity</label>
                    <input required type="number" name="capacity"
                        style="border-width: 2px;width: 14rem;height: 2rem;"><br>
                    <input type="checkbox" name="is_isolation" style="margin-left: 43rem;margin-top: -3rem;">
                    <div style="margin-left: 45rem;margin-top: -3rem;">Isolation</div><br>

                    <input type="submit" value="Add hospital" class="update-btn3">

                </form>
            </div>

            <h1 class="add-hero">All hospitals</h1>
            <h2 class="add-hero2">Determine which hospital to be an isolation</h2><br>
            <form action="/staff/moh/manage-hospitals/update" method="POST">
                @csrf
                <div class="tbl-header">
                    <table>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>City</th>
                            <th>Total capacity</th>
                            <th>Intensive care beds</th>
                            <th>Available intensive care beds</th>
                            <th>Available regular beds</th>
                            <th>Isolation</th>
                        </tr>
                    </table>
                </div>
                <div class="tbl-content">
                    <table>
                        @foreach ($hospitals as $hospital)
                            <tr>
                                <input type="hidden" class="id" value="{{ $hospital->id }}" name="id[]">
                                <td>{{ $hospital->id }}</td>
                                <td>{{ $hospital->name }}</td>
                                <td>{{ $hospital->city }}</td>
                                <td>{{ $hospital->capacity }}</td>
                                {{-- <td>{{ $hospital->care_beds }}</td>
                            <td>{{ $hospital->avail_care_beds }}</td>
                            <td>{{ $hospital->available_beds }}</td> --}}
                                <td><input type="number" min="0" max="1" name="is_isolation[]"
                                        value="{{ $hospital->is_isolation }}" style="color:black"> </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
                <input type="submit" value="Update" class="update-btn4">
            </form>
        </div>
    </div>
    <script src="{{ asset('js/manage-hospitals.js') }}"></script>
</x-app-layout>
