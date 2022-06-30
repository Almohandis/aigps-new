<x-app-layout>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" rel="stylesheet">

    <script>
        var errors = {
            national_id: '',
            password: ''
        };

        function updateError() {
            for (var key in errors) {
                if (errors[key] == '#') {
                    document.getElementById(key + '_mark').classList.remove('text-danger');
                    document.getElementById(key + '_mark').classList.add('text-success');
                    document.getElementById(key + '_mark').classList.add('fa-check');
                    document.getElementById(key + '_mark').classList.remove('fa-close');
                    document.getElementById(key + '_error').innerHTML = '';
                    document.getElementById(key + '_mark').style.color = 'green';
                    document.getElementById('submitBtn').disabled = false;
                } else if (errors[key] != '') {
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
                <img class="img-fluid align-middle mt-5 mt-md-3 mt-lg-0" height="300px"
                    src="{{ asset('images/login2.jpg') }}" alt="AIGPS">
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

                    <!-- Modal and button -->
                    <button type="button" style="display: inline-block; width:100px; margin-buttom: 10px" class="btn btn-outline-info" data-bs-toggle="modal"
                        data-bs-target="#exampleModal"><svg xmlns="http://www.w3.org/2000/svg" width="16"
                            height="16" fill="currentColor" class="bi bi-question-circle" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                            <path
                                d="M5.255 5.786a.237.237 0 0 0 .241.247h.825c.138 0 .248-.113.266-.25.09-.656.54-1.134 1.342-1.134.686 0 1.314.343 1.314 1.168 0 .635-.374.927-.965 1.371-.673.489-1.206 1.06-1.168 1.987l.003.217a.25.25 0 0 0 .25.246h.811a.25.25 0 0 0 .25-.25v-.105c0-.718.273-.927 1.01-1.486.609-.463 1.244-.977 1.244-2.056 0-1.511-1.276-2.241-2.673-2.241-1.267 0-2.655.59-2.75 2.286zm1.557 5.763c0 .533.425.927 1.01.927.609 0 1.028-.394 1.028-.927 0-.552-.42-.94-1.029-.94-.584 0-1.009.388-1.009.94z" />
                        </svg> Help</button>

                    <div class="modal fade" style="top: 100px;" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Login help</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p><b>If your account is not verified, you need to verify your account first:</b></p>
                                    <b>1.</b> Open your email.<br>
                                    <b>2.</b> Follow the link provided to you in order to verify your account.<br>
                                    <b>3.</b> Try to log in again.
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
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
                                if (!isValidNid(input.value)) {
                                    input.style.outline = "red solid thin";
                                    errors.national_id =
                                        'National ID must be valid [National Id must be 14 characters long, and starts with 1,2,3]';
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
                                if (input.value.length >= 8 && containsUpperCase(input.value) && containsLowerCase(input.value) &&
                                    containsNumber(input.value)) {
                                    input.style.outline = "green solid thin";
                                    errors.password = '#';
                                    updateError();
                                } else {
                                    input.style.outline = "red solid thin";
                                    errors.password =
                                        'Password must be at least 8 characters, have a capital and small letter, and have a number.';
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
                            <a class="underline text-start text-muted" href="{{ route('password.request') }}">
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
