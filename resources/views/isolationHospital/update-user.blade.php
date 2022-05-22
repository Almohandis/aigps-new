<x-app-layout>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" rel="stylesheet">

        <script>
            var errors = {
                national_id: '',
                email: '',
                gender: '',
                birthdate: ''
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

        <div class="text-start shadow container bg-white mt-5 rounded px-5 py-3 text-dark">
            <h4 class="mb-3 text-center"> Update Patient Data </h4>

            <x-help-modal></x-help-modal>
            @if ($errors->any())
                <div>
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



            <form method="POST">
                @csrf
                <div class="row">
                    <div class="col-12 col-md-6 mt-2">
                        <i id="national_id_mark" class="fa-solid fa-close text-danger visually-hidden"></i>
                        <label>National ID *</label>
                        <input id="national_id" value="{{$user->national_id}}" type="text" class="form-control" name="national_id" oninput="validateNid(this)" required>
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
                        <label>Name *</label>
                        <input type="text" value="{{$user->name}}" class="form-control" name="name" required>
                        <div id="name_error" class="form-text text-danger"></div>
                    </div>

                    <div class="col-12 col-md-6 mt-2">
                        <i id="email_mark" class="fa-solid fa-close text-danger visually-hidden"></i>
                        <label>Email *</label>
                        <input type="email" value="{{$user->email}}" class="form-control" name="email" oninput="validateEmail(this)" required>
                        <div id="email_error" class="form-text text-danger"></div>
                    </div>

                    <script>
                        function validateEmail(input) {
                            if (isEmail(input.value)) {
                                input.style.outline = "green solid thin";
                                errors.email = '#';
                                updateError();
                            } else {
                                input.style.outline = "red solid thin";
                                errors.email = 'Email is invalid [e.g test@domain.com]';
                                updateError();
                            }
                        }
                        function isEmail(email) {
                            return email.match(
                                /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
                            );
                        };
                    </script>

                    <div class="col-12 col-md-6 mt-2">
                        <label>Address *</label>
                        <input type="text" value="{{$user->address}}" class="form-control" name="address" required>
                    </div>

                    <div class="col-12 col-md-6 mt-2">
                        <label>Nationality *</label>
                        <select name="country" class="form-control">
                            @foreach ($countries as $country)
                                <option value="{{ $country }}">{{ $country }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12 col-md-6 mt-2">
                        <label>City *</label>
                        <select name="city" class="form-control">
                            @foreach ($cities as $city)
                                <option value="{{ $city->name }}">{{ $city->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12 col-md-6 mt-2">
                        <i id="gender_mark" class="fa-solid fa-close text-danger visually-hidden"></i>
                        <label>Gender *</label>

                        <select name="gender" class="form-control" onchange="validateGender(this)" required>
                            <option value="">Select Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>

                        <div id="gender_error" class="form-text text-danger"></div>

                        <script>
                            function validateGender(input) {
                                let nid = document.getElementById('national_id').value;

                                if (! nid[12]) return;

                                if (input.value == 'Male' && nid[12] % 2 != 0) {
                                    input.style.outline = "green solid thin";
                                    errors.gender = '#';
                                    updateError();
                                } else if (input.value == 'Female' && nid[12] % 2 == 0) {
                                    input.style.outline = "green solid thin";
                                    errors.gender = '#';
                                    updateError();
                                } else {
                                    input.style.outline = "red solid thin";
                                    errors.gender = 'Gender must match the gender in your national id';
                                    updateError();
                                }
                            }
                        </script>
                    </div>
                    
                    <div class="col-12 col-md-6 mt-2">
                        <label>Blood Type *</label>

                        <select name="blood_type" class="form-control" required>
                            <option value="">Select Gender</option>
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

                    <div class="col-12 col-md-6 mt-2">
                        <i id="birthdate_mark" class="fa-solid fa-close text-danger visually-hidden"></i>

                        <label>Birthdate *</label>
                        <input type="date" value="{{$user->birthdate}}" class="form-control" name="birthdate" required oninput="validateBirthDate(this)">

                        <div id="birthdate_error" class="form-text text-danger"></div>

                        <script>
                            function validateBirthDate(input) {
                                let nid = document.getElementById('national_id').value;

                                if (! nid[6]) return;

                                let birthdate = new Date(input.value);
                                let birthdate_year = birthdate.getFullYear().toString().substr(-2);
                                let birthdate_month = birthdate.getMonth() + 1;
                                let birthdate_day = birthdate.getDate();

                                let nid_year = parseInt(nid.substring(1, 3));
                                let nid_month = parseInt(nid.substring(3, 5));
                                let nid_day = parseInt(nid.substring(5, 7));

                                if (birthdate_year == nid_year && birthdate_month == nid_month && birthdate_day == nid_day) {
                                    input.style.outline = "green solid thin";
                                    errors.birthdate = '#';
                                    updateError();
                                } else {
                                    input.style.outline = "red solid thin";
                                    errors.birthdate = 'Birthdate must match the birthdate in your national id';
                                    updateError();
                                }
                            }
                        </script>
                    </div>

                <div class="d-flex justify-content-center mt-3">
                    <button class="btn btn-success" id="submitBtn" style="width: 150px;">
                        Submit
                    </button>
                </div>
            </form>
        </div>
</x-app-layout>