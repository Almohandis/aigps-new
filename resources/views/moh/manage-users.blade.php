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
                    <a class="nav-link" href="/staff/moh/manage-doctors">Doctors</a>
                </li>
                <li class="nav-item col-6">
                    <a class="nav-link active" href="#">All Users</a>
                </li>
            </ul>
            <!-- Modal and button -->
        <button type="button" class="btn btn-outline-info" data-bs-toggle="modal" data-bs-target="#exampleModal1"
        style="float: right;"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
            fill="currentColor" class="bi bi-question-circle" viewBox="0 0 16 16">
            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
            <path
                d="M5.255 5.786a.237.237 0 0 0 .241.247h.825c.138 0 .248-.113.266-.25.09-.656.54-1.134 1.342-1.134.686 0 1.314.343 1.314 1.168 0 .635-.374.927-.965 1.371-.673.489-1.206 1.06-1.168 1.987l.003.217a.25.25 0 0 0 .25.246h.811a.25.25 0 0 0 .25-.25v-.105c0-.718.273-.927 1.01-1.486.609-.463 1.244-.977 1.244-2.056 0-1.511-1.276-2.241-2.673-2.241-1.267 0-2.655.59-2.75 2.286zm1.557 5.763c0 .533.425.927 1.01.927.609 0 1.028-.394 1.028-.927 0-.552-.42-.94-1.029-.94-.584 0-1.009.388-1.009.94z" />
        </svg> Help</button>

    <div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true" style="top: 100px;" data-backdrop="static" data-keyboard="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><svg xmlns="http://www.w3.org/2000/svg"
                            width="16" height="16" fill="currentColor" class="bi bi-question-circle"
                            viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                            <path
                                d="M5.255 5.786a.237.237 0 0 0 .241.247h.825c.138 0 .248-.113.266-.25.09-.656.54-1.134 1.342-1.134.686 0 1.314.343 1.314 1.168 0 .635-.374.927-.965 1.371-.673.489-1.206 1.06-1.168 1.987l.003.217a.25.25 0 0 0 .25.246h.811a.25.25 0 0 0 .25-.25v-.105c0-.718.273-.927 1.01-1.486.609-.463 1.244-.977 1.244-2.056 0-1.511-1.276-2.241-2.673-2.241-1.267 0-2.655.59-2.75 2.286zm1.557 5.763c0 .533.425.927 1.01.927.609 0 1.028-.394 1.028-.927 0-.552-.42-.94-1.029-.94-.584 0-1.009.388-1.009.94z" />
                        </svg> &nbsp; How to add a casual user as a doctor to any hospital ?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body" style="height: 300px; overflow:scroll;">
                    <p><b>This page contains information of all users, do the following steps to add a user as a doctor: </b></p>
                    <b>1.</b> First, search the name of the user you want to add to hospital.
                    <br>
                    <b>2.</b> Click on "Update" button to add the wanted user.
                    <br>
                    <b>3.</b> A popup will appear containing a drop-down list that contains all the hospitals affiliated with the Ministry of Health.
                    <br>
                    <b>4.</b> Choose the name of the hospital.
                    <br>
                    <b>5.</b> If you don't want to complete the process, click "Close" button to cancel.
                    <br>
                    <b>6.</b> To continue adding the user to the hospital, click "Update" button.
                    <br>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
            <h4 class="text-center my-3"> All Users </h4>

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
                        <th scope="col">Modify</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->national_id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>
                                <button aigps-doctor-id="{{$user->id}}" onclick="openHospitalModal(this)" data-bs-toggle="modal" data-bs-target="#hospitalModal" class="btn btn-outline-primary">Update</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div>
                {{ $users->links() }}
            </div>
        </div>

        <div class="modal fade" style="margin-top: 100px" id="hospitalModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="hospitalModalLabel">Add User to Hospital</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form method="POST" id="hospitalSelect">
                        @csrf
                        <div class="modal-body">
                            <select name="hospital" class="form-control form-select-lg mb-3" required>
                                <option value="">Select Hospital</option>
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
