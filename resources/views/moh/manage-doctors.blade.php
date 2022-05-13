<x-app-layout>
    <link href="{{asset('css/reservation.css')}}" rel="stylesheet">

    <div class="mt-5 text-center">
        <h1 class="aigps-title">Manage Hospital Doctors</h1>

        @if (session('success'))
            <div class="container alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif
        <x-help-modal></x-help-modal>
        @if($errors->any())
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
            <ul class="nav nav-tabs row">
                <li class="nav-item col-6">
                    <a class="nav-link active" href="#">Doctors</a>
                </li>
                <li class="nav-item col-6">
                    <a class="nav-link" href="/staff/moh/manage-doctors/users">All Users</a>
                </li>
            </ul>
        
            <h4 class="text-center my-3"> All Doctors </h4>

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
                                            <option value="national_id">National ID</option>
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
                        <th scope="col">Hospital</th>
                        <th scope="col">Modify</th>
                        <th scope="col">Details</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($doctors as $doctor)
                        <tr>
                            <td>{{ $doctor->national_id }}</td>
                            <td>{{ $doctor->name }}</td>
                            <td>{{ $doctor->hospital->name }}</td>
                            <td>
                                <button aigps-doctor-id="{{$doctor->id}}" onclick="openHospitalModal(this)" data-bs-toggle="modal" data-bs-target="#hospitalModal" class="btn btn-outline-primary">Update</button>
                            </td>
                            <td>
                                <a href="/staff/moh/manage-doctors/{{$doctor->id}}/details" class="btn btn-outline-success">Details</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div>
                {{ $doctors->links() }}
            </div>
        </div>

        <div class="modal fade" style="margin-top: 100px" id="hospitalModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="hospitalModalLabel">Change User Hospital</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form method="POST" id="hospitalSelect">
                        @csrf
                        <div class="modal-body">
                            <select name="hospital" class="form-control form-select-lg mb-3" required>
                                <option value="">Select Hospital</option>
                                <option value="-1" class="bg-danger text-white">Remove Hospital</option>
                                @foreach ($hospitals as $hospital)
                                    <option value="{{ $hospital->id }}">{{ $hospital->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script>
            function openHospitalModal(event) {
                let doctorId = event.getAttribute('aigps-doctor-id');

                let hospitalSelect = document.getElementById('hospitalSelect');
                hospitalSelect.action = `/staff/moh/manage-doctors/doctors/${doctorId}/update`;
            }
        </script>
    </div>
</x-app-layout>
