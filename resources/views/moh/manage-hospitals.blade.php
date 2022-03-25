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
            
            <div class="tbl-header">
                <table>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>City</th>
                        <th>Total capacity</th>
                        {{-- <td>Intensive care beds</td>
                <td>Available intensive care beds</td>
                <td>Available regular beds</td> --}}
                        <th>Update</th>
                        <th>Delete</th>
                    </tr>

                </table>
            </div>
            <div class="tbl-content">
                <table>
                    @foreach ($hospitals as $id => $hospital)
                        <tr>
                            <input type="hidden" class="id" value="{{ $hospital->id }}" name="id[]">
                            <td>{{ $id + 1 }}</td>
                            <td>{{ $hospital->name }}</td>
                            <td>{{ $hospital->city }}</td>
                            <td>{{ $hospital->capacity }}</td>
                            <td><a href="/staff/moh/manage-hospitals/{{$hospital->id}}/update" class="text-blue-500"> Update </a></td>
                            <td><a href="/staff/moh/manage-hospitals/{{$hospital->id}}/delete" class="text-red-500"> Delete </a></td>
                            
                        </tr>
                    @endforeach
                </table>
            </div>
            
            
        </div>
    </div>
    <script src="{{ asset('js/manage-hospitals.js') }}"></script>
</x-app-layout>
