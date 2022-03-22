<x-app-layout>
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 mt-9">
        <div class="notification">
            @if (session('message'))
                {{ session('message') }}
            @endif
        </div>
        <div class="pt-8 sm:pt-0">



            <h1 class="hospital-patients">Hospital patients</h1>
            @php
                $i = 1;
            @endphp
            @if ($patients)
                <div class="tbl-header2">
                    <table>
                        <tr>
                            <th>National ID</th>
                            <th>Name</th>
                            <th style="padding-left: 3rem;">Birthdate</th>
                            <th style="padding-left: 2.5rem;">Gender</th>
                            <th style="padding-left: 3rem;">Address</th>
                            <th style="padding-left: 7rem;">Telephone number</th>
                            <th style="padding-left: 8rem;">Blood type</th>
                            <th style="padding-left: 9rem;">Diagnose status</th>
                            <th colspan="3" style="padding-left: 15rem;">Actions</th>
                        </tr>
                    </table>
                </div>
                <div class="tbl-content2">
                    <table>
                        @foreach ($patients as $patient)
                            <form method="POST"
                                action="/staff/isohospital/infection/save/{{ $patient->national_id }}">
                                @csrf
                                <tr>
                                    <td>{{ $patient->national_id }}</td>
                                    <td><input type="text" contenteditable="false" name="name"
                                            value="{{ $patient->name }}" style="margin-left: -4rem;width: 12rem;">
                                    </td>
                                    <td><input type="date" contenteditable="false" name="birthdate"
                                            value="{{ $patient->birthdate }}"
                                            style="margin-left: 4px;height: 2.4rem;width: 7.5rem;border-width: 1px;border-color: black;">
                                    </td>
                                    <td><input type="text" contenteditable="false" name="gender"
                                            value="{{ $patient->gender }}" style="width: 5rem;"></td>
                                    <td><input type="text" contenteditable="false" name="address"
                                            value="{{ $patient->address }}"
                                            style="margin-left: -3rem;width: 13.5rem;">
                                    </td>
                                    <td><input type="text" contenteditable="false" name="telephone_number"
                                            value="{{ $patient->telephone_number }}"
                                            style="width: 10rem;margin-left: 2.5rem;">
                                    </td>
                                    <td><input type=" text" contenteditable="false" name="blood_type"
                                            value="{{ $patient->blood_type }}"
                                            style="width: 4rem;margin-left: 5rem;height: 2rem;border-width: 1px;border-color: black;">
                                    </td>
                                    <td style="padding-left: 3rem;"><input type="number" contenteditable="false"
                                            name="is_diagnosed" value="{{ $patient->is_diagnosed }}" min="0" max="1"
                                            style="height: 2rem;border-color: black;border-width: 1px;">
                                    </td>
                                    <td><input type="submit" contenteditable="false" class="buttons"
                                            data-id="{{ $patient->id++ }}"
                                            data-patient_id="{{ $patient->national_id }}" value="Save"
                                            style="margin-left: 4.3rem;background-color: #0fb639;color: white;width: 3rem;cursor: pointer;height: 2rem;">
                                    </td>
                                    <td>
                                        <div
                                            style="background-color: crimson;color: white;height: 1.6rem;width: 5rem;text-align: center;margin-left: 2rem;cursor: pointer;">
                                            <a href="{{ route('infection-checkout', $patient->national_id) }}">Check
                                                out</a>
                                        </div>
                                    </td>
                                    <td style="width: 4rem;">
                                        <div
                                            style="background-color: #5a5acd;height: 1.6rem;color: white;width: 3rem;text-align: center;margin-left: -1rem;cursor: pointer;">
                                            <a href="{{ route('infection-more', $patient->national_id) }}">More</a>
                                        </div>
                                    </td>
                                </tr>
                            </form>
                        @endforeach
                    </table>
                </div>
            @endif
            <form action="/staff/isohospital/infection/add" method="GET" style="margin-top: 2rem;">
                <input type="submit" value="Add new patient" class="add-new-patient-btn">
            </form>
        </div>
    </div>
</x-app-layout>
