<x-app-layout>
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 mt-9">
        <div class="notification">
            @if (session('message'))
                {{ session('message') }}
            @endif
        </div>
        <div class="pt-8 sm:pt-0">

            <div>
                @php
                    $i = 1;
                @endphp
                <h1>Staff roles</h1>
                <form action="/staff/admin/update" method="POST">
                    @csrf
                    <table>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>City</th>
                            <th>National ID</th>
                            <th>Role</th>
                        </tr>
                        @foreach ($members as $member)
                            <tr>
                                <input type="hidden" value="{{ $member->id }}" name="id[]">
                                <td>{{ $i++ }}</td>
                                <td>{{ $member->name }}</td>
                                <td>{{ $member->city }}</td>
                                <td>{{ $member->national_id }}</td>
                                <td> <input type="number" min="1" max="8" name="role_id[]"
                                        value="{{ $member->role_id }}"> </td>
                            </tr>
                        @endforeach
                    </table>
                    <input type="submit" value="Update">
                </form>
            </div>

            <h1>Add staff member</h1><br>
            <form action="/staff/admin/add" method="POST">
                @csrf
                <label for="national_id">National ID</label>
                <input type="text" name="national_id" id="national_id" required><br>
                <label for="role_id">Role ID</label>
                <input type="number" min="1" max="8" name="role_id" id="role_id" required><br>
                <input type="submit" value="Add">
            </form>
        </div>
    </div>
</x-app-layout>
