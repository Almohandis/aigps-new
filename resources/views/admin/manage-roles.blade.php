<x-app-layout>
    <link href="{{asset('css/reservation.css')}}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" rel="stylesheet">

    <script>
        var errors = {
            national_id: ''
        };

        function updateError() {
            for(var key in errors) {
                if (errors[key] == '#') {
                    document.getElementById(key + '_mark').classList.remove('text-danger');
                    document.getElementById(key + '_mark').classList.add('text-success');
                    document.getElementById(key + '_mark').classList.add('fa-check');
                    document.getElementById(key + '_mark').classList.remove('fa-close');
                    document.getElementById(key + '_error').innerHTML = '';
                    document.getElementById(key + '_mark').style.color = 'green';
                    document.getElementById('submitBtn').disabled = false;
                }
                else if (errors[key] != '') {
                    document.getElementById(key + '_mark').classList.remove('text-success');
                    document.getElementById(key + '_mark').classList.add('text-danger');
                    document.getElementById(key + '_mark').classList.add('fa-close');
                    document.getElementById(key + '_mark').classList.remove('fa-check');
                    document.getElementById(key + '_mark').classList.remove('visually-hidden');
                    document.getElementById(key + '_error').innerHTML = errors[key];
                    document.getElementById('submitBtn').disabled = true;
                } else {
                    document.getElementById(key + '_error').innerHTML = '';
                    document.getElementById(key + '_mark').classList.add('visually-hidden');
                }
            }
        }
    </script>

    <div class="mt-5 text-center">
        <h1 class="aigps-title">Manage Staff Roles</h1>

        <div class="table-responsive text-start shadow container bg-white mt-5 rounded px-5 py-3 text-dark">
            <h4 class="text-center mb-3"> List of Employees </h4>

            @if ($errors->any())
                <div>
                    <div class="alert alert-danger" role="alert">
                        <p>Something went wrong.</p>

                        <ul class="">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            @if (session('success'))
                <div>
                    <div class="alert alert-success" role="alert">
                        <p> {{ session('success') }} </p>
                    </div>
                </div>
            @endif

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">National Id</th>
                        <th scope="col">City</th>
                        <th scope="col">Role</th>
                        <th scope="col">Update</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($employees as $employee)
                        <tr>
                            <td>{{ $employee->name }}</td>
                            <td>{{ $employee->national_id }}</td>
                            <td>{{ $employee->city }}</td>
                            <form method="POST" action="/staff/admin/{{ $employee->id }}/update">
                                <td>
                                    <select class="form-control" name="role">
                                        @foreach($roles as $index => $role)
                                            <option value="{{ $index + 1 }}" {{ $employee->role_id == $index + 1 ? 'selected' : '' }}>{{ $role }}</option>
                                        @endforeach
                                    </select>
                                </td>

                                <td>
                                    @csrf
                                    <button class="btn btn-outline-primary"> Update </button>
                                </td>
                            </form>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="flex">
                <ul class="pagination justify-content-center">
                    @if ($employees->previousPageUrl())
                        <li class="page-item"><a class="page-link" href="/staff/admin?page={{ $employees->currentPage() - 1 }}">Previous</a></li>
                    @endif
                    
                    
                    @for($page = 1; $page <= $employees->lastPage(); $page++)
                        <li class="page-item"><a class="page-link" href="/staff/admin?page={{ $page }}">{{ $page }}</a></li>
                    @endfor

                    @if ($employees->nextPageUrl())
                        <li class="page-item"><a class="page-link" href="/staff/admin?page={{ $employees->currentPage() + 1 }}">Next</a></li>
                    @endif
                </ul>
            </div>
        </div>

        <div class="text-start shadow container bg-white mt-5 rounded px-5 py-3 text-dark">
            <h4 class="mb-3 text-center"> Add a new Employee </h4>    
            <form action="/staff/admin/add" method="POST">
                @csrf

                <div class="row">
                    <div class="col-12 col-md-6 mt-2">
                        <i id="national_id_mark" class="fa-solid fa-close text-danger visually-hidden"></i>
                        <label>National ID *</label>
                        <input id="national_id" type="text" class="form-control" name="national_id" oninput="validateNid(this)" required>
                        <div id="national_id_error" class="form-text text-danger"></div>
                    </div>

                    <div class="col-12 col-md-6 mt-2">
                        <label>Role *</label>
                        <select class="form-control" name="role_id">
                            @foreach($roles as $index => $role)
                                <option value="{{ $index + 1 }}">{{ $role }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <script>
                    function validateNid(input) {
                        if (! isValidNid(input.value)) {
                            input.style.outline = "red solid thin";
                            errors.national_id = 'National ID must be valid [National Id must be 14 characters long, and starts with 1,2,3]';
                            updateError();
                        } else {
                            input.style.outline = "green solid thin";
                            errors.national_id = '#';
                            updateError();
                        }
                    }

                    function isValidNid(input) {
                        let days_per_month = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];

                        if (input.length != 14 || isNaN(input) || !(input[0] == '2' || input[0] == '3')) {
                            return false;
                        }

                        let month = parseInt(input.substring(3, 5));
                        let day = parseInt(input.substring(5, 7));

                        if (month > 12 || month < 1) {
                            return false;
                        }

                        if (day > days_per_month[month - 1] || day < 1) {
                            return false;
                        }

                        return true;
                    }
                </script>
                <div class="container text-center my-3">
                    <button id="submitBtn" type="submit" style="width: 300px;" class="btn btn-success" disabled>Add</button>
                </div>
            </form>

        </div>
    </div>
</x-app-layout>
