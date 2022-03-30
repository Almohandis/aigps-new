<x-app-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <!-- Validation Errors -->
    <x-auth-validation-errors class="mb-4" :errors="$errors" />

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" rel="stylesheet">
    <script>
        var errors = {
            national_id: '',
            password: ''
        };

        function updateError() {
            for (var key in errors) {
                if (errors[key] == '#') {
                    document.getElementById(key + '_mark').style.display = 'inline-block';
                    document.getElementById(key + '_mark').classList.add('fa-check');
                    document.getElementById(key + '_mark').classList.remove('fa-close');
                    document.getElementById(key + '_error').innerHTML = '';
                    document.getElementById(key + '_mark').style.color = 'green';
                    document.getElementById('submitBtn').disabled = false;
                } else if (errors[key] != '') {
                    document.getElementById(key + '_mark').style.color = 'red';
                    document.getElementById(key + '_mark').classList.add('fa-close');
                    document.getElementById(key + '_mark').classList.remove('fa-check');
                    document.getElementById(key + '_mark').style.display = 'inline-block';
                    document.getElementById(key + '_error').innerHTML = errors[key];
                    document.getElementById('submitBtn').disabled = true;
                } else {
                    document.getElementById(key + '_error').innerHTML = '';
                    document.getElementById(key + '_mark').style.display = 'none';
                }
            }
        }
    </script>
    <div class="text-start shadow container bg-white mt-5 rounded px-5 py-3 text-dark">
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="row">
                <div class="col-4 mt-2">
                    <img src="EDIT3.png" style="height: 150px;width: 150px;">
                </div>
                <br>
                <div class="col-12 mt-2" style="font-size: 25px;margin-bottom: 2%;">
                    AIGPS
                </div>
                <!-- National ID -->
                <div class="col-12 mt-2">
                    <i id="national_id_mark" class="fa-solid fa-close text-danger visually-hidden"></i>
                    <label>National ID</label>
                    <input style="width:20rem;" type="text" class="form-control" name="national_id" :value="old('national_id')"
                        oninput="validateNid(this)" required autofocus>
                    <div id="national_id_error" class="form-text text-danger"></div>
                </div>

                <!-- Password -->
                <div class="col-12 mt-2">
                    <i id="password_mark" class="fa-solid fa-close text-danger visually-hidden"></i>
                    <label>Password</label>
                    <input id="password" style="width:20rem;" type="password" class="form-control" name="password"
                        oninput="validatePassword(this)" required autocomplete="current-password">
                    <div id="password_error" class="form-text text-danger"></div>
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
                <div class="container">
                    @if (Route::has('password.request'))
                        <a class="underline text-sm text-gray-600 hover:text-gray-900"
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
</x-app-layout>
