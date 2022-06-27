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
        <h1 class="aigps-title">Manage National Id Database</h1>

        <div class="table-responsive text-start shadow container bg-white mt-5 rounded px-5 py-3 text-dark">
             <!-- Modal and button -->
             <button type="button" class="btn btn-outline-info" data-bs-toggle="modal" data-bs-target="#exampleModal"
             style="float: right;"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                 fill="currentColor" class="bi bi-question-circle" viewBox="0 0 16 16">
                 <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                 <path
                     d="M5.255 5.786a.237.237 0 0 0 .241.247h.825c.138 0 .248-.113.266-.25.09-.656.54-1.134 1.342-1.134.686 0 1.314.343 1.314 1.168 0 .635-.374.927-.965 1.371-.673.489-1.206 1.06-1.168 1.987l.003.217a.25.25 0 0 0 .25.246h.811a.25.25 0 0 0 .25-.25v-.105c0-.718.273-.927 1.01-1.486.609-.463 1.244-.977 1.244-2.056 0-1.511-1.276-2.241-2.673-2.241-1.267 0-2.655.59-2.75 2.286zm1.557 5.763c0 .533.425.927 1.01.927.609 0 1.028-.394 1.028-.927 0-.552-.42-.94-1.029-.94-.584 0-1.009.388-1.009.94z" />
             </svg> Help</button>

         <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
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
                             </svg> &nbsp; What is the "Modify National ID" Page ?</h5>
                         <button type="button" class="btn-close" data-bs-dismiss="modal"
                             aria-label="Close"></button>
                     </div>
                     <div class="modal-body" style="height: 300px; overflow:scroll;">
                         <p><b></b></p>
                         • This page shows all the  "National IDs".
                         <br>
                         • By clicking on "Delete" button, you can delete the National ID from the Database.
                         <br>
                         • You can edit the National ID , by editing the ID in the "National ID" textbox and click on "Update" button.
                         <br>
                         • If you wish to add a new National ID to the database, you can fill the section "Add
                         a new National ID".
                         <br>
                     </div>
                     <div class="modal-footer">
                         <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                     </div>
                 </div>
             </div>
         </div>
            <h4 class="text-center mb-3"> List of national IDs </h4>

            <x-help-modal></x-help-modal>
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
                <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

                <script>
                    Swal.fire({
                        icon: 'success',
                        title: '{{ session('success') }}',
                        showConfirmButton: false,
                        timer: 1500
                    })
                </script>

                <div>
                    <div class="alert alert-success" role="alert">
                        <p> {{ session('success') }} </p>
                    </div>
                </div>
            @endif

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">National Id</th>
                        <th scope="col">Update</th>
                        <th scope="col">Delete</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($nationalIds as $nationalId)
                        <tr>
                            <form method="POST" action="/staff/nationalids/update">
                                <input value="{{$nationalId->national_id}}" type="hidden" name="national_id">
                                <td>
                                    <i class="fa-solid fa-close text-danger visually-hidden"></i>
                                    <input value="{{$nationalId->national_id}}" placeholder="NationalId" type="text" class="form-control" name="national_id_new" oninput="validateNid(this)" required>
                                    <br>
                                    <div class="form-text text-danger"></div>
                                </td>

                                <td>
                                    @csrf
                                    <button class="btn btn-outline-primary"> Update </button>
                                </td>
                            </form>

                            <form method="POST" action="/staff/nationalids/delete">
                                <td>
                                    @csrf
                                    <input value="{{$nationalId->national_id}}" type="hidden" name="national_id">
                                    <button class="btn btn-outline-danger"> Delete </button>
                                </td>
                            </form>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="flex">
                <ul class="pagination justify-content-center">
                    @if ($nationalIds->previousPageUrl())
                        <li class="page-item"><a class="page-link" href="/staff/nationalids?page={{ $nationalIds->currentPage() - 1 }}">Previous</a></li>
                    @endif
                    
                    
                    @for($page = 1; $page <= $nationalIds->lastPage(); $page++)
                        <li class="page-item"><a class="page-link" href="/staff/nationalids?page={{ $page }}">{{ $page }}</a></li>
                    @endfor

                    @if ($nationalIds->nextPageUrl())
                        <li class="page-item"><a class="page-link" href="/staff/nationalids?page={{ $nationalIds->currentPage() + 1 }}">Next</a></li>
                    @endif
                </ul>
            </div>
        </div>

        <div class="text-center shadow container bg-white mt-5 rounded px-5 py-3 text-dark">
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
                            </svg> &nbsp; How to add a new question to the survey ?</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body" style="height: 300px; overflow:scroll;">
                        <p><b>You can do the following steps:</b></p>
                        <b>1.</b> Insert National ID in the textbox.
                        <br>
                        <b>2.</b> Click "Add" button, to proceed adding National ID to the database.
                        <br>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
            <h4 class="mb-3 text-center"> Add a new National Id </h4>    
            <form action="/staff/nationalids/add" method="POST">
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
