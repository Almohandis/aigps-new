<x-app-layout>
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 mt-9">
        <div class="notification">
            @if (session('message'))
                {{ session('message') }}
            @endif
        </div>
        <form action="/staff/isohospital/infection/add" method="POST">
            @csrf
            <div class="add-patient-form">
                <h1 class="add-hero">Patient data</h1>
                <br>
                <div style="margin-left: 5rem;">
                    <label for="name">Name</label>
                    <input required type="text" name="name" id="name" class="mt-2" value="">
                </div>
                <div style="margin-top: -3rem;margin-left: 40rem;">
                    <label for="national-id">National ID</label>
                    <input oninput="validateNid(this)" required type="number" name="national_id" min="1" id="national-id" class="mt-2"
                        value="" style="height: 2.5rem;border-width: 1px;border-color: black;">

                    <script>
                        function validateNid(input) {
                            if (input.value.length != 14 || isNaN(input.value) || input.value[0] != '2' || input.value[0] != '1' || input.value[0] != '3') {
                                input.style.outline = "red solid thin";
                            } else {
                                input.style.outline = "green solid thin";
                            }
                        }
                    </script>
                </div>
                <br>
                <div style="margin-left: 5rem;">
                    <label for="birthdate">Birthdate</label>
                    <input required type="date" name="birthdate" id="birthdate" class="mt-2" value="">
                </div><br>
                <div style="margin-top: -3.7rem;margin-left: 40rem;">
                    <label for="address">Address</label>
                    <input required type="text" name="address" id="address2" class="mt-2" value="">
                </div><br>
                <div style="margin-left: 5rem;">
                    <label for="city">City</label>
                    <select required name="city" id="city" class="mt-2" style="margin-left: 0.5rem;">
                        <option hidden disabled selected>Select a city</option>
                        @foreach ($data['cities'] as $city)
                            <option value="{{ $city }}">{{ $city }}</option>
                        @endforeach
                    </select>
                </div><br>
                <div style="margin-top: -3.7rem;margin-left: 40rem;">
                    <label for="telephone_number">Telephone number</label>
                    <input type="number" name="telephone_number" id="telephone_number2" class="mt-2" value="">
                </div><br>
                <div style="margin-left: 5rem;">
                    <label for="gender">Gender</label>
                    <select required name="gender" id="gender2">
                        <option value="" selected hidden disabled>Choose gender</option>
                        <option value="male">Male</option>
                        <option value="female">female</option>
                    </select>
                </div><br>
                <div style="margin-top: -3.5rem;margin-left: 40rem;">
                    <label for="country">Country</label>
                    <select name="country" id="country2">
                        <option hidden disabled selected>Select country</option>
                        @foreach ($data['countries'] as $country)
                            <option value="{{ $country }}">{{ $country }}</option>
                        @endforeach
                    </select>
                </div><br>
                <div style="margin-left: 5rem;">
                    <label for="blood_type">Blood type</label>
                    <select required name="blood_type" id="blood_type" class="block mt-2"
                        style="margin-top: -2rem;margin-left: 5rem;">
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
                <br>
                <div style="margin-top: -4rem;margin-left: 40rem;">
                    <label for="is_diagnosed">Has diagnosed</label>
                    <select required name="is_diagnosed" id="">
                        <option value="" hidden disabled selected>Select diagnose status</option>
                        <option value="1">Diagnosed</option>
                        <option value="0">Not diagnosed</option>
                    </select>
                </div><br><br>

                <h2 style="margin-left: 5rem;">Mobile phones</h2>
                <div id="phones" style="margin-left: 6rem;">
                </div>
                <input type="button" id="add-phone" value="Add phone">
                <br><br>

                <h1 style="margin-left: 5rem;">Infections</h1>
                <div id="infections" style="margin-left: 7rem;margin-bottom: 1rem;">
                </div>
                <input type="button" id="add-infection" value="Add infection">
                <br><br>

                <input type="submit" value="Submit" class="submit">
                <button onclick="window.location.href='/staff/isohospital/infection'" class="back-btn2"
                    type="button">
                    BACK
                </button>
                <button onclick="window.location.href='/'" class="cancel-btn2" type="reset">
                    CANCEL
                </button>
        </form>

    </div>
    </div>
    <script>
        function deletePhone(event) {
            let elements = document.getElementsByClassName(event.target.id);
            for (let i = elements.length - 1; i >= 0; i--) {
                if (elements[i].classList.contains('phone')) {
                    elements[i].remove();
                }
            }
        }

        function deleteInfection(event) {
            console.log(event.target.id);
            let elements = document.getElementsByClassName(event.target.id);
            for (let i = elements.length - 1; i >= 0; i--) {
                if (elements[i].classList.contains('infection')) {
                    elements[i].remove();
                }
            }
        }
    </script>
    <script src="{{ asset('js/isohospital-edit-user.js') }}"></script>
</x-app-layout>
