<x-app-layout>
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 mt-9">
        <div class="notification">
            @if (session('message'))
                {{ session('message') }}
            @endif
        </div>
        <div class="pt-8 sm:pt-0">
            <h1 class="add-hero2">All hospitals</h1>
            <h2 class="add-hero3">Select a hospital to manage its doctors</h2><br>
            <select form="add-doctor-form" name="hospital_id" id="list">
                <option value="" selected hidden disabled>Please select a hospital</option>
                @foreach ($hospitals as $hospital)
                    <option value="{{ $hospital->id }}">{{ $hospital->name }}</option>
                @endforeach
            </select>
            <form id="add-doctor-form" action="/staff/moh/manage-doctors/add" method="POST">
                @csrf
                <div class="tbl-header" style="border:1px solid black">
                    <table>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>National ID</th>
                            <th>Action</th>
                        </tr>
                    </table>
                </div>
                <div class="tbl-content">
                    <table></table>
                </div>
                <br>
                <div class="add-doctor-div">
                    <h2 class="add-hero2" style="margin-bottom: 2rem;">To add new doctor, select a hospital and
                        enter national ID of doctor below</h2>
                    <input oninput="validateNid(this)" type="number" name="national_id" id="add-doctor" placeholder="Type doctor's national ID"
                        style="height: 2rem;margin-left: 23rem;border-width: 2px;border-color: gray;border-radius: 5px;">

                    <script>
                        function validateNid(input) {
                            if (input.value.length != 14 || isNaN(input.value) || input.value[0] != '2' || input.value[0] != '1' || input.value[0] != '3') {
                                input.style.outline = "red solid thin";
                            } else {
                                input.style.outline = "green solid thin";
                            }
                        }
                    </script>
                    
                    <input type="submit" value="Add doctor" class="add-doc-btn">
                </div>
            </form>
        </div>
    </div>
    <script>
        window.onload = () => {

            //#list is the id of the select element
            const list = document.getElementById('list');
            const table = document.querySelectorAll('table')[1];

            //# Append header row to table
            function appendHeader() {
                let headerId = document.createElement('td');
                headerId.innerHTML = '#';
                let headerName = document.createElement('td');
                headerName.innerHTML = 'Name';
                let headerNid = document.createElement('td');
                headerNid.innerHTML = 'National ID';
                let headerAction = document.createElement('td');
                headerAction.innerHTML = 'Action';
                let headerTr = document.createElement('tr');
                headerTr.appendChild(headerId);
                headerTr.appendChild(headerName);
                headerTr.appendChild(headerNid);
                headerTr.appendChild(headerAction);
                table.appendChild(headerTr);
            }

            //# Append data rows to table
            function appendRow(data, i) {
                let id = document.createElement('td');
                id.innerHTML = i + 1;
                let name = document.createElement('td');
                name.innerHTML = data.name;
                let national_id = document.createElement('td');
                national_id.innerHTML = data.national_id;
                let button = document.createElement('td');
                let btn = document.createElement('input');
                btn.setAttribute('type', 'button');
                btn.value = 'Remove';
                btn.addEventListener('click', () => {
                    deleteDoctor(data.id);
                });
                button.appendChild(btn);
                let tr = document.createElement('tr');
                tr.appendChild(id);
                tr.appendChild(name);
                tr.appendChild(national_id);
                tr.appendChild(button);
                table.appendChild(tr);
            }

            //# Get doctors of the selected hospital
            function getDoctors() {
                table.innerHTML = '';
                // appendHeader();
                let id = list.value;
                let xhttp = new XMLHttpRequest();
                xhttp.onload = function() {
                    let data = xhttp.response;
                    for (let i = 0; i < data.length; i++) {
                        appendRow(data[i], i);
                    }
                }
                xhttp.open("GET", "/staff/moh/manage-doctors/" + id);
                xhttp.responseType = 'json';
                xhttp.send();
            }

            //#delete doctor
            function deleteDoctor(id) {
                if (confirm('Are you sure you want to remove this doctor from hospital?')) {
                    let xhttp = new XMLHttpRequest();
                    xhttp.onload = function() {
                        getDoctors();
                        if (xhttp.response) {
                            document.getElementsByClassName('notification')[0].innerHTML =
                                'Doctor removed successfully';
                        } else {
                            document.getElementsByClassName('notification')[0].innerHTML =
                                'Something went wrong, please try again';
                        }
                    }
                    xhttp.open("GET", "/staff/moh/manage-doctors/remove-doctor/" + id);
                    xhttp.send();
                }
            }

            list.addEventListener('change', getDoctors);

        }
    </script>
</x-app-layout>
