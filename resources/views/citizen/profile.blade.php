<x-app-layout>

        @if (session('message'))
            <div class="alert alert-danger">
                {{ session('message') }}
            </div>
        @endif
        <div class="text-start shadow container bg-white mt-5 rounded px-5 py-3 text-dark">
            <h4 class="mb-3 text-center"> Account Settings </h4>
            <form action="/profile/update" method="POST">
                @csrf
                <div class="row">
                    <!-- Name -->
                    <div class="col-12 col-md-6 mt-2">
                        <label>Name</label>
                        <input type="text" class="form-control" name="name" :value="$user->name" required autofocus>
                    </div>

                    <!-- Email Address -->
                    <div class="col-12 col-md-6 mt-2">
                        <i id="email_mark" class="fa-solid fa-close text-danger visually-hidden"></i>
                        <label>Email</label>
                        <input type="email" class="form-control" name="email" :value="$user->email"
                            oninput="validateEmail(this)" required>
                        <div id="email_error" class="form-text text-danger"></div>
                    </div>
                    <!-- Password -->
                    <div class="col-12 col-md-6 mt-2">
                        <i id="password_mark" class="fa-solid fa-close text-danger visually-hidden"></i>
                        <label>Password</label>
                        <input id="password" type="password" class="form-control" name="password"
                            oninput="validatePassword(this)" required autocomplete="new-password>
                        <div id=" password_error" class="form-text text-danger">
                    </div>
                </div>

                <!-- Confirm Password -->
                <div class="col-12 col-md-6 mt-2">
                    <i id="password_confirmation_mark" class="fa-solid fa-close text-danger visually-hidden"></i>
                    <label>Confirm Password</label>
                    <input type="password" class="form-control" name="password_confirmation"
                        oninput="validatePasswordConfirm(this)" required>
                    <div id="password_confirmation_error" class="form-text text-danger"></div>
                </div>

                <!-- Address -->
                <div class="col-12 col-md-6 mt-2">
                    <label>Address</label>
                    <input type="text" class="form-control" name="address" :value="$user->address" required autofocus>
                </div>

                <!-- Telephone Number -->
                <div class="col-12 col-md-6 mt-2">
                    <label>Telephone Number</label>
                    <input type="text" class="form-control" name="telephone_number" :value="$user->telephone_number"
                        required autofocus>
                </div>

                <!-- Country -->
                <div class="col-12 col-md-6 mt-2">
                    <label>Country</label>
                    <select :value="$user->country" name="country" class="form-control">
                        @foreach ($countries as $country)
                            <option value="{{ $country }}">{{ $country }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- City -->
                <div class="col-12 col-md-6 mt-2">
                    <label>City</label>
                    <select name="city" class="form-control">
                        @foreach ($cities as $city)
                            <option value="{{ $city }}">{{ $city }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Gender -->
                <div class="col-12 col-md-6 mt-2">
                    <label>Gender</label>
                    <select name="gender" class="form-control">
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>

                <!-- Birthdate -->
                <div class="col-12 col-md-6 mt-2">
                    <label>Birthdate</label>
                    <input type="date" class="form-control" name="birthdate" :value="$user->birthdate" required>
                </div>
                <input type="submit" value="Update" class="btn btn-success" id="submitBtn" style="width: 150px;">
        </div>
        </form>
    </div>

    <div class="text-start shadow container bg-white mt-5 rounded px-5 py-3 text-dark" id="passport">
        <div class="row"
            style="form-control">
            <div class="col-12" style="text-align: center;">
            If you have a passport and want to request your <strong>medical passport</strong>, type in your
            passport number and click on the button below
            </div>
            <form action="/medical-passport" method="POST" style="text-align: center;margin-top: 3%;margin-bottom: 3%;">
                @csrf
                <input type="text" name="passport_number">
                <input type="submit" value="Request medical passport" class="req-btn">
            </form>
            <div class="m-auto" style="text-align: center;">
                {{ QrCode::size(300)->generate($user->national_id) }}
            </div>
        </div>
    </div>


    <script>
        function ChangeView(view) {
            document.getElementById('profile').classList.add('hidden');
            document.getElementById('passport').classList.add('hidden');
            document.getElementById(view).classList.remove('hidden');
        }
    </script>
</x-app-layout>
