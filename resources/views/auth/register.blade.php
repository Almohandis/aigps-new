<x-app-layout>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" rel="stylesheet">

        <script>
            var errors = {
                national_id: '',
                email: '',
                password: '',
                password_confirmation: '',
                workemail: '',
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
            <h4 class="mb-3 text-center"> Register </h4>

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


            <form method="POST">
                @csrf
                <div class="row">
                    <div class="col-12 col-md-6 mt-2">
                        <i id="national_id_mark" class="fa-solid fa-close text-danger visually-hidden"></i>
                        <label>National ID *</label>
                        <input type="text" class="form-control" name="national_id" oninput="validateNid(this)" required>
                        <div id="national_id_error" class="form-text text-danger"></div>
                    </div>

                    <script>
                        function validateNid(input) {
                            if (input.value.length != 14 || isNaN(input.value) || !(input.value[0] == '2' || input.value[0] == '1' || input.value[0] == '3')) {
                                input.style.outline = "red solid thin";
                                errors.national_id = 'National ID is invalid [National Id must be 14 characters long, and starts with 1,2,3]';
                                updateError();
                            } else {
                                input.style.outline = "green solid thin";
                                errors.national_id = '#';
                                updateError();
                            }
                        }
                    </script>

                    <div class="col-12 col-md-6 mt-2">
                        <label>Name *</label>
                        <input type="text" class="form-control" name="name" required>
                        <div id="name_error" class="form-text text-danger"></div>
                    </div>

                    <div class="col-12 col-md-6 mt-2">
                        <i id="email_mark" class="fa-solid fa-close text-danger visually-hidden"></i>
                        <label>Email *</label>
                        <input type="email" class="form-control" name="email" oninput="validateEmail(this)" required>
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
                                errors.password = 'Password must be at least 8 characters';
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
                                errors.password_confirmation = 'Password confirmation must be at least 8 characters and match password';
                                updateError();
                            }
                        }
                    </script>

                    <div class="col-12 col-md-6 mt-2">
                        <label>Address *</label>
                        <input type="text" class="form-control" name="address" required>
                    </div>

                    <div class="col-12 col-md-6 mt-2">
                        <label>Telephone Number *</label>
                        <input type="text" class="form-control" name="telephone_number" required>
                    </div>

                    <div class="col-12 col-md-6 mt-2">
                        <label>Country *</label>
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
                                <option value="{{ $city }}">{{ $city }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12 col-md-6 mt-2">
                        <label>Gender *</label>
                        <select name="gender" class="form-control">
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>

                    <div class="col-12 col-md-6 mt-2">
                        <label>Birthdate *</label>
                        <input type="date" class="form-control" name="birthdate" required>
                    </div>

                    <div class="col-12 col-md-6 mt-2">
                        <i id="workemail_mark" class="fa-solid fa-close text-danger visually-hidden"></i>
                        <label>Work Email (optional)</label>
                        <input type="email" class="form-control" name="workemail" oninput="validateWorkEmail(this)">
                        <div id="workemail_error" class="form-text text-danger"></div>
                    </div>

                    <script>
                        function validateWorkEmail(input) {
                            if (isEmail(input.value)) {
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

                    <div class="col-12 col-md-6 mt-2" id="phones">
                        <label>Mobile Number *</label>
                        <input type="number" class="form-control" name="phone1" required>
                    </div>

                    <script>
                        var phones = 2;
                        var phone_input = document.getElementById('phones');

                        function addPhone() {
                            var phone = phone_input.cloneNode(true);
                            phone.setAttribute('id', 'phone' + phones);
                            phone.children[1].value = '';
                            phone.children[1].name = 'phone' + phones;

                            phone_input.parentNode.insertBefore(phone, phone_input.nextSibling);

                            phones++;

                            if (phones > 2) {
                                document.getElementById('removeAPhone').classList.remove('visually-hidden');
                            }
                        }

                        function removePhone() {
                            if (phones > 2) {
                                phones--;
                                document.getElementById('phone' + phones).remove();
                                if (phones == 2) {
                                    document.getElementById('removeAPhone').classList.add('visually-hidden');
                                }
                            }
                        }
                    </script>
                </div>

                <div class="d-flex mt-3 justify-content-center">
                    <div class="btn btn-outline-danger border-0 visually-hidden" onclick="removePhone()" id="removeAPhone">
                        Remove phone
                    </div>

                    <div class="btn btn-outline-primary border-0" onclick="addPhone()">
                        Add Phone
                    </div>
                </div>

                <div class="mt-4">
                    <a class="text-muted" href="/login">
                        Already registered?
                    </a>
                </div>

                <div class="d-flex justify-content-between mt-3">
                    <button class="btn btn-outline-secondary border-0">
                        Cancel
                    </button>

                    <button class="btn btn-success" id="submitBtn" style="width: 150px;" disabled>
                        Submit
                    </button>
                </div>
            </form>
        </div>
</x-app-layout>