<x-app-layout>
    @if (session('message'))
        <div class="alert alert-danger">
            {{ session('message') }}
        </div>
    @endif

    <div class="text-start shadow container bg-white mt-5 rounded px-5 py-3 text-dark">
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
                            
                            <div class="mt-4 row justify-content-center">
                                <input type="submit" value="Update" class="btn btn-success" id="submitBtn" style="width: 150px;">
                            </div>
                        </form>
                    </div>
                </div>
            </div>

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
                            <input type="submit" value="Request medical passport" class="btn btn-primary mx-2">
                        </form>

                        <div class="m-auto" style="text-align: center;">
                            {{ QrCode::size(300)->generate($user->national_id) }}
                        </div>
                    </div>
                </div>
            </div>
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
