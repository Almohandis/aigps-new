<x-app-layout>
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 mt-9">
        <div class="notification">
            @if (session('message'))
                {{ session('message') }}
            @endif
        </div>
        <div class="pt-8 sm:pt-0">
            <h1>All hospitals</h1>
            <h2>Select a hospital to manage its doctors</h2><br>
            <select name="hospital" id="list">
                <option value="" selected hidden disabled>Please select a hospital</option>
                @foreach ($hospitals as $hospital)
                    <option value="{{ $hospital->id }}">{{ $hospital->name }}</option>
                @endforeach
            </select>
            <form action="/staff/moh/manage-hospitals/update" method="POST">
                @csrf
                <table>
                </table>
                <input type="submit" value="Update">
            </form>
        </div>
    </div>
    <script>
        window.onload = () => {

            //# Constants
            const list = document.getElementById('list');
            const table = document.querySelector('table');

            //# Append table header
            function appendHeader() {
                let headerId = document.createElement('td');
                headerId.innerHTML = '#';
                let headerName = document.createElement('td');
                headerName.innerHTML = 'Name';
                let headerNid = document.createElement('td');
                headerNid.innerHTML = 'National ID';
                let headerAction = document.createElement('td');
                headerAction.innerHTML = 'Action';
                let headerTh = document.createElement('th');
                headerTh.appendChild(headerId);
                headerTh.appendChild(headerName);
                headerTh.appendChild(headerNid);
                headerTh.appendChild(headerAction);
                table.appendChild(headerTh);
            }

            //# Append table rows
            function appendRow(data, i) {
                let id = document.createElement('td');
                id.innerHTML = i + 1;
                let name = document.createElement('td');
                name.innerHTML = data.name;
                let national_id = document.createElement('td');
                national_id.innerHTML = data.national_id;
                let action = document.createElement('td');
                let btn = document.createElement('input');
                btn.setAttribute('type', 'button');
                btn.value = 'Remove';
                btn.addEventListener('click', () => {
                    deleteDoctor(data.id);
                });
                action.appendChild(btn);
                let tr = document.createElement('tr');
                tr.appendChild(id);
                tr.appendChild(name);
                tr.appendChild(national_id);
                tr.appendChild(action);
                table.appendChild(tr);
            }

            //# Get doctors of the selected hospital
            function getDoctors() {
                appendHeader();
                let id = list.value;
                let xhttp = new XMLHttpRequest();
                xhttp.onload = function() {
                    // console.log(xhttp.response);
                    let data = JSON.parse(xhttp.response);
                    let table = document.querySelector('table');
                    for (let i = 0; i < data.length; i++) {
                        appendRow(data[i], i);
                    }
                }
                xhttp.open("GET", "/staff/moh/manage-doctors/" + id);
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

            list.addEventListener('change', getDoctors());

        }
    </script>
</x-app-layout>
