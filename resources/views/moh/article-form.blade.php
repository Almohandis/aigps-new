<x-app-layout>
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 mt-9">
        <div class="notification">
            @if (session('message'))
                {{ session('message') }}
            @endif
        </div>

        @if ($errors->any())
            <div>
                <div class="font-medium text-red-600">
                    {{ __('Whoops! Something went wrong.') }}
                </div>

                <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="pt-8 sm:pt-0">
            <h1>Add new article</h1>
            <form action="/staff/moh/add-article" enctype="multipart/form-data" method="POST">
                @csrf
                <label for="title">Article title</label>
                <input type="text" name="title" id="title" placeholder="Enter article title" required>
                <label for="content">Article content</label>
                <textarea name="content" id="content" cols="30" rows="10" placeholder="Enter article content" required></textarea>
                <label for="image">Add image</label>
                <input type="file" name="image" id="image">
                <label for="full-link">(Optional) Link to the full article</label>
                <input type="text" name="full_link" id="full-link" placeholder="Enter full article link">
                <label for="video">(Optional) Link to video</label>
                <input type="text" name="link" id="video" placeholder="Enter video link as an iFrame tag">
                <input type="submit" value="Add article">
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
