<x-app-layout>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" rel="stylesheet">

    <script>
        var errors = {
            national_id: '',
            email: '',
            password: '',
            password_confirmation: '',
            workemail: ''
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
                }
                else if (errors[key] != '') {
                    document.getElementById(key + '_mark').classList.remove('text-success');
                    document.getElementById(key + '_mark').classList.add('text-danger');
                    document.getElementById(key + '_mark').classList.add('fa-close');
                    document.getElementById(key + '_mark').classList.remove('fa-check');
                    document.getElementById(key + '_mark').classList.remove('visually-hidden');
                    document.getElementById(key + '_error').innerHTML = errors[key];
                } else {
                    document.getElementById(key + '_error').innerHTML = '';
                    document.getElementById(key + '_mark').classList.add('visually-hidden');
                }
            }
        }
    </script>

    <div class="text-start shadow container bg-white mt-5 rounded px-5 py-3 text-dark">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

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
    
        <div class="accordion" id="accordionExample">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne">
                        Account Settings
                    </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <form action="/profile/update" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-12 col-md-6 mt-2">
                                    <i id="national_id_mark" class="fa-solid fa-close text-danger visually-hidden"></i>
                                    <label>National ID *</label>
                                    <input value="{{Auth::user()->national_id}}" id="national_id" type="text" class="form-control" name="national_id" oninput="validateNid(this)" required>
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

                                    function updateNidRelatedData(nationalid) {
                                        let millennium = parseInt(nationalid[0]);

                                        let nid_year = nationalid.substring(1, 3);
                                        let nid_month = parseInt(nationalid.substring(3, 5));
                                        let nid_day = parseInt(nationalid.substring(5, 7));
                                        
                                        let nid_gender = parseInt(nationalid[12]);

                                        let year = '';

                                        if (nationalid[0] == 2) {
                                            year = '19' + nid_year;
                                        } else {
                                            year = '20' + nid_year;
                                        }

                                        let month = nid_month < 10 ? '0' + nid_month : nid_month;
                                        let day = nid_day < 10 ? '0' + nid_day : nid_day;

                                        let birthdate = document.getElementById('birthdate');

                                        let gender = nid_gender % 2 == 0 ? 'female' : 'male';
                                        document.getElementById(gender).selected = true;

                                        birthdate.value = `${year}-${month}-${day}`;
                                    }
                                </script>

                                <div class="col-12 col-md-6 mt-2">
                                    <label>Name *</label>
                                    <input value="{{Auth::user()->name}}" type="text" class="form-control" name="name" required>
                                    <div id="name_error" class="form-text text-danger"></div>
                                </div>

                                <div class="col-12 col-md-6 mt-2">
                                    <i id="email_mark" class="fa-solid fa-close text-danger visually-hidden"></i>
                                    <label>Email *</label>
                                    <input value="{{Auth::user()->email}}" type="email" class="form-control" name="email" oninput="validateEmail(this)" required>
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
                                    <i id="password_mark" class="fa-solid fa-close text-danger visually-hidden"></i>
                                    <label>Password *</label>
                                    <input id="password" type="password" class="form-control" name="password" oninput="validatePassword(this)" required>
                                    <div id="password_error" class="form-text text-danger"></div>
                                </div>

                                <script>
                                    function validatePassword(input) {
                                        if (input.value.length >= 8 && containsUpperCase(input.value) && containsLowerCase(input.value) && containsNumber(input.value)) {
                                            input.style.outline = "green solid thin";
                                            errors.password = '#';
                                            updateError();
                                        } else {
                                            input.style.outline = "red solid thin";
                                            errors.password = 'Password must be at least 8 characters, have a capital and small letter, and have a number.';
                                            updateError();
                                        }
                                    }
                                    function containsUpperCase(str) {
                                        return /[A-Z]/.test(str);
                                    }
                                    function containsLowerCase(str) {
                                        return /[a-z]/.test(str);
                                    }
                                    function containsNumber(str) {
                                        return /[0-9]/.test(str);
                                    }
                                </script>

                                <div class="col-12 col-md-6 mt-2">
                                    <i id="password_confirmation_mark" class="fa-solid fa-close text-danger visually-hidden"></i>
                                    <label>Confirm Password *</label>
                                    <input type="password" class="form-control" name="password_confirmation" oninput="validatePasswordConfirm(this)" required>
                                    <div id="password_confirmation_error" class="form-text text-danger"></div>
                                </div>

                                <script>
                                    function validatePasswordConfirm(input) {
                                        if (input.value.length >= 8 && input.value == document.getElementById('password').value) {
                                            input.style.outline = "green solid thin";
                                            errors.password_confirmation = '#';
                                            updateError();
                                        } else {
                                            input.style.outline = "red solid thin";
                                            errors.password_confirmation = 'Password confirmation must match password';
                                            updateError();
                                        }
                                    }
                                </script>

                                <div class="col-12 col-md-6 mt-2">
                                    <label>Address *</label>
                                    <input value="{{Auth::user()->address}}" type="text" class="form-control" name="address" required>
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
                                    <label>Gender *</label>

                                    <select name="gender" class="form-control" id="gender" required readonly required>
                                        <option id="male" value="Male">Male</option>
                                        <option id="female" value="Female">Female</option>
                                    </select>
                                </div>

                                <div class="col-12 col-md-6 mt-2">
                                    <label>Birthdate *</label>
                                    <input type="date" class="form-control" id="birthdate" name="birthdate" required readonly>
                                </div>

                                <div class="col-12 col-md-6 mt-2">
                                    <i id="workemail_mark" class="fa-solid fa-close text-danger visually-hidden"></i>
                                    <label>Work Email</label>
                                    <input value="{{Auth::user()->workemail}}" type="email" class="form-control" name="workemail" oninput="validateWorkEmail(this)">
                                    <div id="workemail_error" class="form-text text-danger"></div>
                                </div>

                                <div class="col-12 col-md-6 mt-2">
                                    <label>Mobile Number *</label>
                                    <input value="{{Auth::user()->telephone_number}}" type="text" class="form-control" name="telephone_number" required>
                                </div>

                                <script>
                                    function validateWorkEmail(input) {
                                        if (isEmail(input.value) || input.value == "") {
                                            input.style.outline = "green solid thin";
                                            errors.workemail = '#';
                                            updateError();
                                        } else {
                                            input.style.outline = "red solid thin";
                                            errors.workemail = 'Work Email is invalid [e.g test@domain.com]';
                                            updateError();
                                        }
                                    }
                                </script>
                            </div>

                            <div class="row">
                                <button class="btn btn-success mt-3">
                                    Update
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            @if($hasPassport)
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo">
                            Medical Passport
                        </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <div class="row"
                                style="form-control">
                                <div class="col-12" style="text-align: center;">
                                    If you have a passport and want to request your <strong>medical passport</strong>, type in your
                                    passport number and click on the button below
                                </div>
                                <form action="/medical-passport" method="POST" class="d-flex my-3">
                                    @csrf
                                    <input type="text" name="passport_number" class="form-control mx-2">
                                    <input type="submit" value="Request medical passport" class="btn btn-success mx-2">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script>
        function ChangeView(view) {
            document.getElementById('profile').classList.add('hidden');
            document.getElementById('passport').classList.add('hidden');
            document.getElementById(view).classList.remove('hidden');
        }

        validateNid(document.getElementById('national_id'));
    </script>
</x-app-layout>
