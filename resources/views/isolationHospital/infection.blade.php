<x-app-layout>
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 mt-9">
        <div class="notification">
            @if (session('message'))
                {{ session('message') }}
            @endif
        </div>
        <div class="pt-8 sm:pt-0">

            <form action="/staff/isohospital/infection/add" method="GET">
                <input type="submit" value="Add new patient">
            </form>

            <h1>Hospital patients</h1>
            @php
                $i = 1;
            @endphp
            @if ($patients)
                <div class="tbl-header">
                    <table>
                        <tr>
                            <th>National ID</th>
                            <th>Name</th>
                            <th>Birthdate</th>
                            <th>Gender</th>
                            <th>Address</th>
                            <th>Telephone number</th>
                            <th>Blood type</th>
                            <th>Diagnose status</th>
                            <th colspan="3">Actions</th>
                        </tr>
                    </table>
                </div>
                <div class="tbl-content">
                    <table>
                        @foreach ($patients as $patient)
                            <form method="POST"
                                action="/staff/isohospital/infection/save/{{ $patient->national_id }}">
                                @csrf
                                <tr>
                                    <td>{{ $patient->national_id }}</td>
                                    <td><input type="text" contenteditable="false" name="name"
                                            value="{{ $patient->name }}">
                                    </td>
                                    <td><input type="date" contenteditable="false" name="birthdate"
                                            value="{{ $patient->birthdate }}"></td>
                                    <td><input type="text" contenteditable="false" name="gender"
                                            value="{{ $patient->gender }}"></td>
                                    <td><input type="text" contenteditable="false" name="address"
                                            value="{{ $patient->address }}"></td>
                                    <td><input type="text" contenteditable="false" name="telephone_number"
                                            value="{{ $patient->telephone_number }}">
                                    </td>
                                    <td><input type="text" contenteditable="false" name="blood_type"
                                            value="{{ $patient->blood_type }}"></td>
                                    <td><input type="number" contenteditable="false" name="is_diagnosed"
                                            value="{{ $patient->is_diagnosed }}" min="0" max="1"></td>
                                    <td><input type="submit" contenteditable="false" class="buttons"
                                            data-id="{{ $patient->id++ }}"
                                            data-patient_id="{{ $patient->national_id }}" value="Save">
                                    </td>
                                    <td><a href="{{ route('infection-checkout', $patient->national_id) }}">Check
                                            out</a></td>
                                    <td><a href="{{ route('infection-more', $patient->national_id) }}">More</a></td>
                                </tr>
                            </form>
                        @endforeach
                    </table>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
