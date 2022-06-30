<x-app-layout>
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
    <x-help-modal></x-help-modal>
        @if ($errors->any())
            <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

            <script>
                Swal.fire({
                    icon: 'error',
                    title: '{{implode(', ', $errors->all())}}',
                    showConfirmButton: true
                })
            </script>
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

        @if (session('success'))
            <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

            <script>
                Swal.fire({
                    icon: 'success',
                    title: '{{ session('success') }}',
                    showConfirmButton: false,
                    timer: 2500
                })
            </script>

            <div class="container alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif

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
                             </svg> &nbsp; How to follow up a patient or modify the patient's data ?</h5>
                         <button type="button" class="btn-close" data-bs-dismiss="modal"
                             aria-label="Close"></button>
                     </div>
                     <div class="modal-body" style="height: 300px; overflow:scroll;">
                         <p><b>You can do the following steps:</b></p>
                                <b>1.</b> Find the patient's national ID from "Today's appointments".<br>
                                <b>2.</b> Insert the national ID.<br>
                                <b>3.</b> Click "Submit" button.<br>
                                <b>4.</b> You will be directed to a page with the patients information and you can modify it.<br>
                     </div>
                     <div class="modal-footer">
                         <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                     </div>
                 </div>
             </div>
         </div>
            <h4 class="mb-3 text-center"> Find patients in your campaign </h4>

            <form method="POST">
                @csrf
                <div class="row">
                    <div class="mt-2">
                        <i id="national_id_mark" class="fa-solid fa-close text-danger visually-hidden"></i>
                        <label>National ID *</label>
                        <input id="national_id" type="text" class="form-control" name="national_id" oninput="validateNid(this)" required>
                        <div id="national_id_error" class="form-text text-danger"></div>
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
                                updateNidRelatedData(input.value);
                            }
                        }

                        function isValidNid(input) {
                            let days_per_month = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];

                            if (input.length != 14 || isNaN(input) || !(input[0] == '2' || input[0] == '3')) {
                                return false;
                            }

                            let nid_year = input.substring(1, 3);
                            let year = '';

                            if (input[0] == 2) {
                                year = '19' + nid_year;
                            } else {
                                year = '20' + nid_year;
                            }

                            let month = parseInt(input.substring(3, 5));
                            let day = parseInt(input.substring(5, 7));

                            // check if the date isn't greater than today
                            let today = new Date();
                            let today_year = today.getFullYear();
                            let today_month = today.getMonth() + 1;
                            let today_day = today.getDate();

                            if (year > today_year || (year == today_year && month > today_month) || (year == today_year && month == today_month && day > today_day)) {
                                return false;
                            }

                            // check if the date isn't less than 1900
                            if (year < 1900) {
                                return false;
                            }

                            if (month > 12 || month < 1) {
                                return false;
                            }

                            if (day > days_per_month[month - 1] || day < 1) {
                                return false;
                            }

                            return true;
                        }
                    </script>
                </div>

                <div class="d-flex justify-content-center mt-3">
                    <button class="btn btn-success" id="submitBtn" style="width: 150px;" disabled>
                        Submit
                    </button>
                </div>
            </form>

        </div>


        @if(isset($appointments))
            <div class="text-center shadow container bg-white mt-5 rounded px-5 py-3 text-dark">
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
                            </svg> &nbsp; What is the "Today's Appointments" section ?</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body" style="height: 300px; overflow:scroll;">
                        <p><b></b></p>
                        • This section contains national IDs .
                        <br>
                        • The national IDs belongs to patients that have appointments today.
                        <br>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
                <h4 class="mb-3 text-center"> Today's Appointments </h4>

                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">National ID</th>
                            <th scope="col">Date & Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($appointments as $appointment)
                            <tr>
                                <td>{{ $appointment->name }}</td>
                                <td>{{ $appointment->national_id }}</td>
                                <td>{{ $appointment->date }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</x-app-layout>
