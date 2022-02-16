window.onload = () => {

    //#delete doctor
    function deleteDoctor(id){
        console.log(6)
    }

    let list = document.getElementById('list');
    list.addEventListener('change', () => {
        let id = list.value;
        let xhttp = new XMLHttpRequest();
        xhttp.onload = function () {
            console.log(xhttp.response);
            let data = JSON.parse(xhttp.response);
            let table = document.querySelector('table');
            for (let i = 0; i < data.length; i++) {
                let id = document.createElement('td');
                id.innerHTML = i + 1;
                let name = document.createElement('td');
                name.innerHTML = data[i].name;
                let national_id = document.createElement('td');
                national_id.innerHTML = data[i].national_id;
                let button = document.createElement('td');
                let btn = document.createElement('input');
                btn.setAttribute('type', 'button');
                btn.value = 'Remove';
                btn.setAttribute('onclick', 'deleteDoctor(' + data[i].id + ')');
                button.appendChild(btn);
                let tr = document.createElement('tr');
                tr.appendChild(id);
                tr.appendChild(name);
                tr.appendChild(national_id);
                tr.appendChild(button);
                table.appendChild(tr);
            }
        }
        xhttp.open("GET", "/staff/moh/manage-doctors/" + id);
        // xhttp.responseType = "json";
        xhttp.send();
    });

}
