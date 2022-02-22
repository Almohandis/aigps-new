<x-app-layout>
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 mt-9">
        <div class="notification">
            @if (session('message'))
                {{ session('message') }}
            @endif
        </div>

        <form action="/staff/isohospital/infection/add/{{ $data['user']['national_id'] }}" method="POST">
            @csrf
            <div class="pt-8 sm:pt-0">
                <h1>Patient data</h1>
                <label for="national-id">National ID</label>
                <input type="text" id="national-id" class="mt-2" value="{{ $data['user']['national_id'] }}"
                    readonly><br>
                <label for="name">Name</label>
                <input type="text" name="name" id="name" class="mt-2"
                    value="{{ $data['user']['name'] }}"><br>
                <label for="birthdate">Birthdate</label>
                <input type="date" name="birthdate" id="birthdate" class="mt-2"
                    value="{{ $data['user']['birthdate'] }}"><br>
                <label for="address">Address</label>
                <input type="text" name="address" id="address" class="mt-2"
                    value="{{ $data['user']['address'] }}"><br>
                <label for="telephone_number">Telephone number</label>
                <input type="text" name="telephone_number" id="telephone_number" class="mt-2"
                    value="{{ $data['user']['telephone_number'] }}"><br>
                <label for="gender">Gender</label>
                <input type="text" name="gender" id="gender" class="mt-2"
                    value="{{ $data['user']['gender'] }}"><br>
                <label for="country">Country</label>
                <select name="country" id="country">
                    <option value="{{ $data['user']['country'] }}" selected>{{ $data['user']['country'] }}</option>
                    @foreach ($data['countries'] as $country)
                        <option value="{{ $country }}">{{ $country }}</option>
                    @endforeach
                </select><br>
                <label for="blood_type">Blood type</label>
                <input type="text" name="blood_type" id="blood_type" class="mt-2"
                    value="{{ $data['user']['blood_type'] }}"><br>
                <label for="is_diagnosed">Has diagnosed</label>
                <input type="text" name="is_diagnosed" id="is_diagnosed" class="mt-2"
                    value="{{ $data['user']['is_diagnosed'] }}"><br><br>

                <h2>Mobile phones</h2>
                <div id="phones">
                    @foreach ($data['phones'] as $phone)
                        <label class="phone {{ $phone['id'] }}" for="phone_number">Phone number</label>
                        <input type="text" name="phones[]" id="{{ $phone['id'] }}"
                            class="mt-2 phone {{ $phone['id'] }}" value="{{ $phone['phone_number'] }}">
                        <input type="button" id="{{ $phone['id'] }}" onclick="deletePhone(event)"
                            class="phone {{ $phone['id'] }}" value="Delete"><br>
                    @endforeach
                </div>
                <input type="button" id="add-phone" value="Add phone">
                <br><br>

                <h1>Infections</h1>
                <div id="infections">
                    @foreach ($data['infections'] as $infection)
                        <label class="infection {{ $infection['id'] }}" for="infection">Infection</label>
                        <input type="date" name="infections[]" id="{{ $infection['id'] }}"
                            class="mt-2 infection {{ $infection['id'] }}"
                            value="{{ $infection['infection_date'] }}">
                        <input type="button" id="{{ $infection['id'] }}" onclick="deleteInfection(event)"
                            class="infection {{ $infection['id'] }}" value="Delete"><br>
                    @endforeach
                </div>
                <input type="button" id="add-infection" value="Add infection">
                <br><br>

                <input type="submit" value="Update">
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
