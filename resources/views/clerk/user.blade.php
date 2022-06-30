<x-app-layout>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" rel="stylesheet">

    <div class="mt-5 text-center">
        <x-help-modal></x-help-modal>
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

        @if (session('success'))
            <div class="container alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <div class="text-start shadow container bg-white mt-5 rounded px-5 py-3 text-dark">
            <h4 class="mb-3 text-center"> Patient Data </h4>
            <div class="row">
                <div>
                    <h5>Personal Data</h6>

                        @if (!$user->is_diagnosed)
                            <div class="container alert alert-info" role="alert">
                                This user has NOT been diagnosed yet.
                            </div>
                        @endif

                        <!-- table containing user name, national_id, city -->
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">Name</th>
                                    <th scope="col">National ID</th>
                                    <th scope="col">City</th>
                                    <th scope="col">Gender</th>
                                    <th scope="col">Blood Type</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->national_id }}</td>
                                    <td>{{ $user->city }}</td>
                                    <td>{{ $user->gender }} </td>
                                    <td>{{ $user->blood_type ?? 'Not Assigned' }} </td>
                                </tr>
                            </tbody>
                        </table>
                </div>

                <div>
                    <h5>Previous Infections</h6>

                        @foreach ($user->infections as $infection)
                            <ul>
                                <li>
                                    This user has been infected on:
                                    <span class="fw-bold">{{ $infection->infection_date }}</span>
                                </li>
                            </ul>
                        @endforeach
                </div>

                <div class="mt-3">
                    <h5>Chronic Diseases</h6>

                        @foreach ($user->diseases as $disease)
                            <ul class="ps-4">
                                <li>
                                    <span class="fw-bold">{{ $disease->name }}</span>
                                </li>
                            </ul>
                        @endforeach
                </div>

                <div class="mt-3">
                    <h5>Vaccines</h6>

                        @if ($passport && $passport->vaccine_name != '')
                            <p>
                                Vaccine type: {{ $passport->vaccine_name }}
                            </p>
                        @endif

                        @foreach ($vaccines as $vaccine)
                            <ul class="ps-4">
                                <li>
                                    User vaccinated at:
                                    <span class="fw-bold">{{ $vaccine->vaccine_date }}</span>
                                </li>
                            </ul>
                        @endforeach
                </div>
            </div>

        </div>

        <div class="text-start shadow container bg-white mt-5 rounded px-5 py-3 text-dark">
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
                                </svg> &nbsp; How to modify patient's data ?</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body" style="height: 300px; overflow:scroll;">
                            <p><b>You can do the following steps:</b></p>
                            <b> • </b> You can add user infection status by:
                            <b>1.</b> First, add the patient's infection date.<br>
                            <b>2.</b> If the user has passed away then check the checkbox<br>
                            <br>
                            <b> • </b> You can add user vaccination status:
                            <b>1.</b> Just add the vaccine name that the user have recieved.<br>
                            <b>2.</b> The vaccination date will be set to the day patient's data is modified.<br>
                            <br>
                            <b> • </b> You can add new chronic disease to the patient's data:
                            <b>1.</b> Click on "Add disease" button.<br>
                            <b>2.</b> A drop-down list will appear choose from it the chronic disease you want to
                            add.<br>
                            <b>3.</b> If you want to remove chronic disease click on "Remove disease" button.<br>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <h4 class="mb-3 text-center"> Modify patient data </h4>
            <form method="POST" action="/staff/clerk/{{ $user->id }}/complete" class="row">
                @csrf
                <div class="col-12 col-md-6 mt-4">
                    <h5>
                        Infection Status
                        <small class="fw-normal text-muted">optional</small>
                    </h5>

                    <div class="row">
                        <div class="mt-2">
                            <label>Infection date: </label>
                            <input type="date" class="form-control" name="infection">

                            <div class="mt-2">
                                <input type="checkbox" name="passed_away">
                                <label>This user has passed away</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6 mt-4">
                    <div class="">
                        <h5 class="m-0">
                            Vaccination
                        </h5>
                        <small class="m-0 text-muted">The vaccination date will be set to today</small>
                    </div>

                    <div class="row">
                        <div class="mt-2">
                            <label>Vaccine name: </label>
                            <input type="text" class="form-control" name="vaccine_name">
                        </div>
                    </div>
                </div>

                @if (!$user->blood_type)
                    <div class="col-12 col-md-6 mt-4">
                        <div class="">
                            <h5 class="m-0">
                                Personal Data
                            </h5>
                        </div>

                        <div class="row">
                            <div class="mt-2">
                                <label>Blood Type </label>

                                <select name="blood_type" class="form-control">
                                    <option value="A+">A+</option>
                                    <option value="A-">A-</option>
                                    <option value="B+">B+</option>
                                    <option value="B-">B-</option>
                                    <option value="AB+">AB+</option>
                                    <option value="AB-">AB-</option>
                                    <option value="O+">O+</option>
                                    <option value="O-">O-</option>
                                </select>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="col-12 col-md-6 mt-4">
                    <div>
                        <h5 class="m-0">
                            Chronic Diseases
                        </h5>
                        <small class="m-0 text-muted">Add new chronic diseases</small>
                    </div>

                    <div class="visually-hidden">
                        <select class="w-full form-control mt-2" id="chronicDisease">
                            <option value="">Select disease</option>
                            <option value="ALS (Lou Gehrig's Disease)">ALS (Lou Gehrig's Disease)</option>
                            <option value="Alzheimer's Disease and other Dementias">Alzheimer's Disease and other
                                Dementias</option>
                            <option value="Arthritis">Arthritis</option>
                            <option value="Asthma">Asthma</option>
                            <option value="Cancer">Cancer</option>
                            <option value="Chronic Obstructive Pulmonary Disease (COPD)">Chronic Obstructive Pulmonary
                                Disease (COPD)</option>
                            <option value="Crohn's Disease">Crohn's Disease</option>
                            <option value="Ulcerative Colitis">Ulcerative Colitis</option>
                            <option value="Inflammatory Bowel Diseases">Inflammatory Bowel Diseases</option>
                            <option value="Irritable Bowel Syndrome">Irritable Bowel Syndrome</option>
                            <option value="Cystic Fibrosis">Cystic Fibrosis</option>
                            <option value="Diabetes">Diabetes</option>
                            <option value="Eating Disorders">Eating Disorders</option>
                            <option value="Heart Disease">Heart Disease</option>
                            <option value="Obesity">Obesity</option>
                            <option value="Oral Health">Oral Health</option>
                            <option value="Osteoporosis">Osteoporosis</option>
                            <option value="Reflex Sympathetic Dystrophy (RSD) Syndrome">Reflex Sympathetic Dystrophy
                                (RSD) Syndrome</option>
                            <option value="Tobacco Use and Related Conditions">Tobacco Use and Related Conditions
                            </option>
                        </select>
                    </div>

                    <div id="diseases">
                    </div>

                    <div class="d-flex mt-3 justify-content-center">
                        <div class="btn btn-outline-danger border-0 visually-hidden" onclick="removeDisease()"
                            id="removeDisease">
                            Remove Disease
                        </div>

                        <div class="btn btn-outline-primary border-0" onclick="addDisease()">
                            Add Disease
                        </div>

                        <script>
                            var diseases = 1;
                            var disease_input = document.getElementById('diseases');

                            function addDisease() {
                                var disease = document.getElementById('chronicDisease').cloneNode(true);
                                disease.setAttribute('name', 'disease' + diseases);

                                disease_input.appendChild(disease);

                                diseases++;

                                if (diseases > 1) {
                                    document.getElementById('removeDisease').classList.remove('visually-hidden');
                                }
                            }

                            function removeDisease() {
                                disease_input.removeChild(disease_input.lastChild);

                                diseases--;

                                if (diseases == 1) {
                                    document.getElementById('removeDisease').classList.add('visually-hidden');
                                }
                            }
                        </script>
                    </div>
                </div>

                <div class="d-flex justify-content-center mt-3">
                    <button class="btn btn-success" style="width: 250px;">
                        Submit
                    </button>
                </div>
            </form>

        </div>
    </div>
</x-app-layout>
