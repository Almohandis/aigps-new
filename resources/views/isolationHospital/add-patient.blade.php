<x-app-layout>
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 mt-9">
        <div class="notification">
            @if (session('message'))
                {{ session('message') }}
            @endif
        </div>
        <form action="/staff/isohospital/infection/add" method="POST">
            @csrf
            <div class="pt-8 sm:pt-0">
                <h1>Patient data</h1>
                <label for="national-id">National ID</label>
                <input required type="number" name="national_id" min="1" id="national-id" class="mt-2" value=""><br>
                <label for="name">Name</label>
                <input required type="text" name="name" id="name" class="mt-2" value=""><br>
                <label for="birthdate">Birthdate</label>
                <input required type="date" name="birthdate" id="birthdate" class="mt-2" value=""><br>
                <label for="address">Address</label>
                <input required type="text" name="address" id="address" class="mt-2" value=""><br>
                <label for="city">City</label>
                <input required type="text" name="city" id="city" class="mt-2" value=""><br>
                <label for="telephone_number">Telephone number</label>
                <input type="number" name="telephone_number" id="telephone_number" class="mt-2" value=""><br>
                <label for="gender">Gender</label>
                <select required name="gender" id="gender">
                    <option value="" selected hidden disabled>Choose gender</option>
                    <option value="male">Male</option>
                    <option value="female">female</option>
                </select><br>
                <label for="country">Country</label>
                <select name="country" id="country">
                    <option value="" hidden disabled selected>Select country</option>
                    @foreach ($data['countries'] as $country)
                        <option value="{{ $country }}">{{ $country }}</option>
                    @endforeach
                </select><br>
                <label for="blood_type">Blood type</label>
                <input required type="text" name="blood_type" id="blood_type" class="mt-2" value=""><br>
                <label for="is_diagnosed">Has diagnosed</label>
                <select required name="is_diagnosed" id="">
                    <option value="" hidden disabled selected>Select diagnose status</option>
                    <option value="1">Diagnosed</option>
                    <option value="0">Not diagnosed</option>
                </select><br><br>

                <h2>Mobile phones</h2>
                <div id="phones">
                </div>
                <input type="button" id="add-phone" value="Add phone">
                <br><br>

                <h1>Infections</h1>
                <div id="infections">
                </div>
                <input type="button" id="add-infection" value="Add infection">
                <br><br>

                <input type="submit" value="Submit">
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
