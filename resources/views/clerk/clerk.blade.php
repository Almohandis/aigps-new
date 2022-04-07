<x-app-layout>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" rel="stylesheet">

    <script>
            var errors = {
                national_id: ''
            };

            function updateError() {
                for(var key in errors) {
                    if (errors[key] == '#') {
                        document.getElementById(key + '_mark').classList.remove('text-danger');
                        document.getElementById(key + '_mark').classList.add('text-success');
                        document.getElementById(key + '_mark').classList.add('fa-check');
                        document.getElementById(key + '_mark').classList.remove('fa-close');
                        document.getElementById(key + '_error').innerHTML = '';
                        document.getElementById(key + '_mark').style.color = 'green';
                        document.getElementById('submitBtn').disabled = false;
                    }
                    else if (errors[key] != '') {
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

    <div class="mt-5 text-center">
        @if ($errors->any())
            <div class="container">
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

        @if (session('success'))
            <div class="container alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <div class="text-center shadow container bg-white mt-5 rounded px-5 py-3 text-dark">
            <h4 class="mb-3 text-center"> Find patients in your campaign </h4>    

            <form method="POST">
                @csrf
                <div class="row">
                    <div class="mt-2">
                        <i id="national_id_mark" class="fa-solid fa-close text-danger visually-hidden"></i>
                        <label>National ID *</label>
                        <input id="national_id" type="text" class="form-control" name="national_id" oninput="validateNid(this)" required>
                        <div id="national_id_error" class="form-text text-danger"></div>
                    </div>

                    <script>
                        function validateNid(input) {
                            if (! isValidNid(input.value)) {
                                input.style.outline = "red solid thin";
                                errors.national_id = 'National ID must be valid [National Id must be 14 characters long, and starts with 1,2,3]';
                                updateError();
                            } else {
                                input.style.outline = "green solid thin";
                                errors.national_id = '#';
                                updateError();
                                updateNidRelatedData(input.value);
                            }
                        }

                        function isValidNid(input) {
                            let days_per_month = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];

                            if (input.length != 14 || isNaN(input) || !(input[0] == '2' || input[0] == '3')) {
                                return false;
                            }

                            let nid_year = input.substring(1, 3);
                            let year = '';

                            if (input[0] == 2) {
                                year = '19' + nid_year;
                            } else {
                                year = '20' + nid_year;
                            }

                            let month = parseInt(input.substring(3, 5));
                            let day = parseInt(input.substring(5, 7));

                            // check if the date isn't greater than today
                            let today = new Date();
                            let today_year = today.getFullYear();
                            let today_month = today.getMonth() + 1;
                            let today_day = today.getDate();

                            if (year > today_year || (year == today_year && month > today_month) || (year == today_year && month == today_month && day > today_day)) {
                                return false;
                            }

                            // check if the date isn't less than 1900
                            if (year < 1900) {
                                return false;
                            }

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

                <div class="d-flex justify-content-center mt-3">
                    <button class="btn btn-success" id="submitBtn" style="width: 150px;" disabled>
                        Submit
                    </button>
                </div>
            </form>

        </div>
    </div>
</x-app-layout>
