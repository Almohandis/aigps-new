<x-app-layout>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" rel="stylesheet">

        <script>
            var errors = {
                national_id: '',
                password: ''
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
            <h4 class="mb-3 text-center"> Login </h4>

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
                </div>

                <div class="row mt-3 text-center justify-content-center">
                    <button id="submitBtn" type="submit" style="width: 250px;" class="btn btn-success btn-block">Login</button>
                </div>
            </form>
        </div>
</x-app-layout>
