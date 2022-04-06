<x-app-layout>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" rel="stylesheet">

    <div class="mt-5 text-center">
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

                    @if (! $user->is_diagnosed)
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

                    @foreach($user->infections as $infection)
                        <ul> 
                            <li>
                                This user has been infection at: 
                                <span class="fw-bold">{{ $infection->infection_date }}</span>
                            </li>
                        </ul>
                    @endforeach
                </div>

                <div class="mt-3">
                    <h5>Chronic Diseases</h6>

                    @foreach($user->diseases as $disease)
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

                    @foreach($vaccines as $vaccine)
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
            <h4 class="mb-3 text-center"> Modify patient data </h4>
            <form method="POST" action="/staff/clerk/{{$user->id}}/complete" class="row">
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
                        </div>
                    </div>
                </div>

                @if ($user->is_diagnosed)
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
                @endif

                @if (! $user->blood_type)
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

                    <div id="diseases">
                    </div>

                    <div class="d-flex mt-3 justify-content-center">
                        <div class="btn btn-outline-danger border-0 visually-hidden" onclick="removeDisease()" id="removeDisease">
                            Remove Disease
                        </div>

                        <div class="btn btn-outline-primary border-0" onclick="addDisease()">
                            Add Disease
                        </div>

                        <script>
                            var diseases = 1;
                            var disease_input = document.getElementById('diseases');

                            function addDisease() {
                                var disease = document.createElement('input');
                                disease.setAttribute('type', 'text');
                                disease.setAttribute('name', 'disease' + diseases);
                                disease.setAttribute('placeholder', 'Disease Name');
                                disease.setAttribute('required', '');
                                disease.setAttribute('class', 'form-control mt-2');

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
