<x-app-layout>
    <link href="{{asset('css/reservation.css')}}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" rel="stylesheet">

    <script>
        var errors = {
            national_id: ''
        };

        function updateError(input) {
            let mark = input.parentElement.children[0];
            let error = input.parentElement.children[3];

            if (errors['national_id'] == '#') {
                mark.classList.remove('text-danger');
                mark.classList.add('text-success');
                mark.classList.add('fa-check');
                mark.classList.remove('fa-close');
                error.innerHTML = '';
                mark.style.color = 'green';
            }
            else if (errors['national_id'] != '') {
                mark.classList.remove('text-success');
                mark.classList.add('text-danger');
                mark.classList.add('fa-close');
                mark.classList.remove('fa-check');
                mark.classList.remove('visually-hidden');
                error.innerHTML = errors['national_id'];
            } else {
                error.innerHTML = '';
                mark.classList.add('visually-hidden');
            }
        }
    </script>

    <div class="mt-5 text-center">
        <h1 class="aigps-title">Manage Doctors</h1>

        @if (session('success'))
            <div class="container alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="container">
                <div class="alert alert-danger" role="alert">
                    <p>Something went wrong. Please check the form below for errors.</p>

                    <ul class="">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <div class="table-responsive text-start shadow container bg-white mt-5 rounded px-5 py-3 text-dark">
            <h4 class="text-center mb-3"> All Doctors in the hospital [{{ $hospital->name }}] </h4>

            
            <div class="accordion mb-4" id="campaignsAccordion">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="flush-headingOne">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#flush-collapseOne">
                            Filters & search
                        </button>
                    </h2>
                    <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne"
                        data-bs-parent="#campaignsAccordion">
                        <div class="accordion-body">
                            <form method="GET" class="row">
                                <div class="form-group mb-2">
                                    <label class="">Search</label>
                                    <input type="text" name="search" class="form-control" placeholder="Search by name" value="{{ request()->search }}">
                                </div>

                                <div class="form-group col-12 col-md-6 col-lg-3">
                                    <label for="sort" class="">Sort by</label>
                                    <div>
                                        <select class="form-control" name="sort">
                                            <option value="">Select Sorting</option>
                                            <option value="name">Name</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group col-12 col-md-6 col-lg-3">
                                    <label class="">Sort Order</label>
                                    <div class="">
                                        <select class="form-control" name="order">
                                            <option value="asc">Ascending</option>
                                            <option value="desc">Descending</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row justify-content-center mt-2 mb-4">
                                    <div class="row justify-content-center mt-2">
                                        <button style="width: 250px" type="submit" class="btn btn-primary">Filter</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">National ID</th>
                        <th scope="col">Name</th>
                        <th scope="col">Remove Doctor</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($doctors as $doctor)
                        <tr>
                            <td>{{ $doctor->national_id }}</td>
                            <td>{{ $doctor->name }}</td>

                            <form method="POST" action="/staff/moh/manage-doctors/doctors/{{$doctor->id}}/delete">
                                <td>
                                    @csrf
                                    <button class="btn btn-outline-danger"> Remove </button>
                                </td>
                            </form>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="flex">
                <ul class="pagination justify-content-center">
                    @if ($doctors->previousPageUrl())
                        <li class="page-item"><a class="page-link" href="/staff/moh/manage-doctors/{{$hospital->id}}?page={{ $doctors->currentPage() - 1 }}">Previous</a></li>
                    @endif
                    
                    
                    @for($page = 1; $page <= $doctors->lastPage(); $page++)
                        <li class="page-item"><a class="page-link" href="/staff/moh/manage-doctors/{{$hospital->id}}?page={{ $page }}">{{ $page }}</a></li>
                    @endfor

                    @if ($doctors->nextPageUrl())
                        <li class="page-item"><a class="page-link" href="/staff/moh/manage-doctors/{{$hospital->id}}?page={{ $doctors->currentPage() + 1 }}">Next</a></li>
                    @endif
                </ul>
            </div>
        </div>

        <div class="text-start shadow container bg-white mt-5 rounded px-5 py-3 text-dark">
            <h4 class="mb-3 text-center"> Add a doctor to this hospital </h4>    
            <form action="/staff/moh/manage-doctors/{{$hospital->id}}/doctors/add" method="POST">
                @csrf

                <div class="row">
                    <div class="col-12 mt-2">
                        <i id="national_id_mark" class="fa-solid fa-close text-danger visually-hidden"></i>
                        <label>National ID *</label>
                        <input id="national_id" type="text" class="form-control" name="national_id" oninput="validateNid(this)" required>
                        <div id="national_id_error" class="form-text text-danger"></div>
                    </div>
                </div>

                <script>
                    function validateNid(input) {
                        if (! isValidNid(input.value)) {
                            input.style.outline = "red solid thin";
                            errors.national_id = 'National ID must be valid [National Id must be 14 characters long, and starts with 1,2,3]';
                            updateError(input);
                        } else {
                            input.style.outline = "green solid thin";
                            errors.national_id = '#';
                            updateError(input);
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
                    <button type="submit" style="width: 300px;" class="btn btn-success">Add</button>
                </div>
            </form>

        </div>
    </div>
</x-app-layout>
