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
                <h1 class="staff-hero">Staff roles</h1>
                <form action="/staff/admin/update" method="POST">
                    @csrf
                    <div class="tbl-header">
                        <table>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>City</th>
                                <th>National ID</th>
                                <th>Role</th>
                            </tr>
                        </table>
                    </div>
                    <div class="tbl-content">
                        <table>
                            @foreach ($members as $member)
                                <tr>
                                    <input type="hidden" value="{{ $member->id }}" name="id[]">
                                    <td>{{ $i++ }}</td>
                                    <td>{{ $member->name }}</td>
                                    <td>{{ $member->city }}</td>
                                    <td>{{ $member->national_id }}</td>
                                    <td> <input style="color:black;" type="number" min="1" max="8" name="role_id[]"
                                            value="{{ $member->role_id }}">
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                    <input type="submit" value="Update" class="update-btn">
                </form>
            </div>
            <div class="add-staff">
                <h1 class="add-hero">Add staff member</h1><br>
                <form action="/staff/admin/add" method="POST">
                    @csrf
                    <label for="national_id" class="national_id">National ID</label>
                    <input oninput="validateNid(this)"  type="text" name="national_id" id="national_id" required>
                    <script>
                        function validateNid(input) {
                            if (input.value.length != 14 || isNaN(input.value) || input.value[0] != '2' || input.value[0] != '1' || input.value[0] != '3') {
                                input.style.outline = "red solid thin";
                            } else {
                                input.style.outline = "green solid thin";
                            }
                        }
                    </script>
                    <label for="role_id" class="role_id">Role ID</label>
                    <input type="number" min="1" max="8" name="role_id" id="role_id" required><br>
                    <input type="submit" value="Add" class="update-btn2">
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
