<x-app-layout>
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 mt-9">
        <div class="notification">
            @if (session('message'))
                {{ session('message') }}
            @endif
        </div>

        <form action="/staff/isohospital/infection/more/{{ $data['user']['national_id'] }}" method="POST">
            @csrf
            <div class="add-patient-form">
                <h1 class="add-hero">Patient data</h1>
                <br>
                <div style="margin-left: 5rem;">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" class="mt-2"
                        value="{{ $data['user']['name'] }}">
                </div>
                <div style="margin-top: -3rem;margin-left: 40rem;">
                    <label for="national-id">National ID</label>
                    <input type="text" id="national-id" class="mt-2"
                        value="{{ $data['user']['national_id'] }}" readonly>
                </div><br>
                <div style="margin-left: 5rem;">
                    <label for="birthdate">Birthdate</label>
                    <input type="date" name="birthdate" id="birthdate" class="mt-2"
                        value="{{ $data['user']['birthdate'] }}">
                </div><br>
                <div style="margin-top: -3.7rem;margin-left: 40rem;">
                    <label for="address">Address</label>
                    <input type="text" name="address" id="address2" class="mt-2"
                        value="{{ $data['user']['address'] }}">
                </div><br>
                <div style="margin-left: 5rem;">
                    <label for="city">City</label>
                    <input required type="text" name="city" id="city" class="mt-2" value="" style="margin-left: 0.5rem;">
                </div><br>
                <div style="margin-top: -3.7rem;margin-left: 40rem;">
                    <label for="telephone_number">Telephone number</label>
                    <input type="text" name="telephone_number" id="telephone_number2" class="mt-2"
                        value="{{ $data['user']['telephone_number'] }}">
                </div><br>
                <div style="margin-left: 5rem;">
                    <label for="gender">Gender</label>
                    <input type="text" name="gender" id="gender2" class="mt-2"
                        value="{{ $data['user']['gender'] }}">
                </div><br>
                <div style="margin-top: -3.5rem;margin-left: 40rem;">
                    <label for="country">Country</label>
                    <select name="country" id="country2">
                        <option value="{{ $data['user']['country'] }}" selected>{{ $data['user']['country'] }}
                        </option>
                        @foreach ($data['countries'] as $country)
                            <option value="{{ $country }}">{{ $country }}</option>
                        @endforeach
                    </select>
                </div><br>
                <div style="margin-left: 5rem;">
                    <label for="blood_type">Blood type</label>
                    {{-- <input type="text" name="blood_type" id="blood_type" class="mt-2"
                    value="{{ $data['user']['blood_type'] }}"><br> --}}

                    <select required name="blood_type" id="blood_type" id="blood_type" class="mt-2">
                        <option selected value="{{ $data['user']['blood_type'] }}">
                            {{ $data['user']['blood_type'] }}
                        </option>
                        <option value="A+">A+</option>
                        <option value="A-">A-</option>
                        <option value="B+">B+</option>
                        <option value="B-">B-</option>
                        <option value="AB+">AB+</option>
                        <option value="AB-">AB-</option>
                        <option value="O+">O+</option>
                        <option value="O-">O-</option>
                    </select>
                </div><br>
                <div style="margin-top: -4rem;margin-left: 40rem;">
                    <label for="is_diagnosed">Has diagnosed</label>
                    <input type="text" name="is_diagnosed" id="is_diagnosed" class="mt-2"
                        value="{{ $data['user']['is_diagnosed'] }}">
                </div><br><br>

                <h2 style="margin-left: 5rem;">Mobile phones</h2>
                <div id="phones" style="margin-left: 6rem;">
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

                <h1 style="margin-left: 5rem;">Infections</h1>
                <div id="infections" style="margin-left: 7rem;margin-bottom: 1rem;">
                    @foreach ($data['infections'] as $infection)
                        <label class="infection {{ $infection['id'] }}" for="infection">Infection</label>
                        <input type="date" name="infections[]" id="{{ $infection['id'] }}"
                            class="mt-2 infection {{ $infection['id'] }}"
                            value="{{ $infection['infection_date'] }}">
                        <div class="infection {{ $infection['id'] }} ">
                            <input type="checkbox" id="{{ $infection['id'] }}" @php
                                if ($infection['is_recovered'] == 1) {
                                    echo 'checked';
                                }
                            @endphp
                                class="mt-2 infection" onchange="checkBoxChange(this)">
                            <input type="hidden" value="{{ $infection['is_recovered'] }}" class="infection"
                                name="is_recovered[]">
                            <label for="" class="infection">Recovered</label>
                        </div>
                        <div class="infection {{ $infection['id'] }}">
                            <input type="checkbox" id="{{ $infection['id'] }}" @php
                                if ($infection['has_passed_away'] == 1) {
                                    echo 'checked';
                                }
                            @endphp
                                class="mt-2 infection" onchange="checkBoxChange(this)">
                            <input type="hidden" value="{{ $infection['has_passed_away'] }}" class="infection"
                                name="has_passed_away[]">
                            <label for="" class="infection">Passed away</label>
                        </div>
                        <input type="button" id="{{ $infection['id'] }}" onclick="deleteInfection(event)"
                            class="infection {{ $infection['id'] }}" value="Delete"><br>
                    @endforeach
                </div>
                <input type="button" id="add-infection" value="Add infection">
                <br><br>

                <input type="submit" value="Update" class="submit">
                <button onclick="window.location.href='/staff/isohospital/infection'"class="back-btn2" type="button">
                    BACK
                </button>
                <button onclick="window.location.href='/'"class="cancel-btn2" type="reset">
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

        function checkBoxChange(element) {
            let target = element.parentElement.querySelector('input[type=hidden]');
            if (target.value == 0) {
                target.value = 1;
            } else {
                target.value = 0;
            }
        }
    </script>
    <script src="{{ asset('js/isohospital-edit-user.js') }}"></script>
</x-app-layout>
