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

    <div class="flex container justify-content-center">
        <div class="text-start shadow container bg-white mt-5 rounded px-3 py-3 text-dark row justify-content-center">
            <div class="col-12 col-md-6 d-md-block d-none row justify-content-center">
                <img class="img-fluid align-middle mt-5 mt-md-3 mt-lg-0" height="300px" src="{{ asset('images/login2.jpg') }}" alt="AIGPS">
            </div>

            <form class="col-12 col-md-6" method="POST" action="{{ route('login') }}">
                @csrf
                <div class="row justify-content-center">
                    <div class="text-center">
                        <img src="EDIT3.png" style="height: 150px;width: 150px;">
                    </div>

                    <h4 class="col-12 mt-2 text-center">
                        AIGPS
                    </h4>
                    
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

                    <!-- National ID -->
                    <div class="col-12 mt-2">
                        <i id="national_id_mark" class="fa-solid fa-close text-danger visually-hidden"></i>
                        <label>National ID</label>
                        <input type="text" class="form-control" name="national_id" :value="old('national_id')"
                            oninput="validateNid(this)" required autofocus>
                        <div id="national_id_error" class="form-text text-danger"></div>

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
                    </div>

                    <!-- Password -->
                    <div class="col-12 mt-2">
                        <i id="password_mark" class="fa-solid fa-close text-danger visually-hidden"></i>
                        <label>Password</label>
                        <input id="password" type="password" class="form-control" name="password"
                            oninput="validatePassword(this)" required autocomplete="current-password">
                        <div id="password_error" class="form-text text-danger"></div>

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

                    <!-- Remember Me -->
                    <div class="col-12">
                        <label for="remember_me" class="inline-flex items-center">
                            <input id="remember_me" type="checkbox"
                                class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                name="remember">
                            <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                        </label>
                    </div>
                </div>
                <div class="col-12">
                    <div class="mt-2">
                        @if (Route::has('password.request'))
                            <a class="underline text-start text-muted"
                                href="{{ route('password.request') }}">
                                {{ __('Forgot your password?') }}
                            </a>
                        @endif
                    </div>

                    <div class="mt-3 mx-auto text-center">
                        <button id="submitBtn" class="btn btn-success">
                            Log in
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
