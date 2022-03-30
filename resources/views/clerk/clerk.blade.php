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
            <h4 class="mb-3 text-center"> Insert Patient Data </h4>    

            <form method="POST">
                @csrf
                <div class="row">
                    <div class="col-12 col-md-6 mt-2">
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

                    <div class="col-12 col-md-6 mt-2">
                        <label>City *</label>
                        <select name="city" class="form-control">
                            @foreach ($cities as $city)
                                <option value="{{ $city }}">{{ $city }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12 col-md-6 mt-2">
                        <label>Blood Type *</label>
                        
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

                    <div class="col-12 col-md-6 mt-2 mb-5">
                        <label class="container">&nbsp;</label>
                        <input class="form-check-input" type="checkbox" name="is_diagnosed" value="true" />
                        <label>Is Diagnosed</label>
                    </div>

                    <hr>

                    <div class="col-12">
                        <h5>
                            Infection Status
                            <small class="fw-normal text-muted">optional</small>
                        </h5>
                    </div>

                    <div class="col-12 col-md-6 mt-2">
                        <label>Infection Date: </label>
                        <input type="date" class="form-control" name="infection">
                    </div>

                    <div class="col-12 col-md-6 mt-2 mb-5">
                        <label class="container">&nbsp;</label>
                        <input class="form-check-input" type="checkbox" name="is_recovered" value="true" />
                        <label>Is Recovered </label>
                    </div>

                    <hr>

                    <div class="col-12">
                        <h5>
                            Chronic Diseases
                            <small class="fw-normal text-muted">optional</small>
                        </h5>
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
                    <button class="btn btn-success" id="submitBtn" style="width: 150px;" disabled>
                        Submit
                    </button>
                </div>
            </form>

        </div>
    </div>
</x-app-layout>
