window.onload = () => {

    //# Add phone to user
    function addPhone() {
        let phone = document.createElement('input');
        phone.type = 'text';
        phone.setAttribute('class', 'phone_number');
        phone.setAttribute('placeholder', 'Phone Number');
        phone.setAttribute('name', 'phones[]');
        let label = document.createElement('label');
        label.setAttribute('for', 'phones[]');
        label.innerHTML = 'Phone Number';
        let br = document.createElement('br');
        let div = document.getElementById('phones');
        div.appendChild(label);
        div.appendChild(phone);
        div.appendChild(br);
    }

    //# Add infection to user
    function addInfection() {
        let infection = document.createElement('input');
        infection.type = 'text';
        infection.setAttribute('class', 'infection');
        infection.setAttribute('placeholder', 'Infection');
        infection.setAttribute('name', 'infections[]');
        let label = document.createElement('label');
        label.setAttribute('for', 'infections[]');
        label.innerHTML = 'Infection';
        let br = document.createElement('br');
        let div = document.getElementById('infections');
        div.appendChild(label);
        div.appendChild(infection);
        div.appendChild(br);
    }

    function editUser(id, patient_id) {
        let table = document.getElementsByTagName('table')[0];
        let tr = table.getElementsByTagName('tr')[id];
        if (tr.children[tr.children.length - 1].firstChild.value == 'Edit') {
            tr.children[tr.children.length - 1].firstChild.value = 'Save';
            for (let i = 1; i < tr.children.length; i++) {
                tr.children[i].firstChild.setAttribute('contenteditable', 'true');
            }
            //# Ajax for getting the user's phone numbers
            let xhttp = new XMLHttpRequest();
            xhttp.onload = function () {
                // let phones = xhttp.response;
                // for (let i = 1; i < phones.length; i++) {
                //     let td = document.createElement('td');
                //     let input = document.createElement('input');
                //     input.setAttribute('type', 'text');
                //     input.setAttribute('value', phones[i]['phone_number']);
                //     td.appendChild(input);
                //     tr.insertBefore(td, tr.children[tr.children.length - 1]);
                //     console.log(phones[i]['phone_number']);
                // }
            }
            xhttp.open("GET", "/staff/isohospital/infection/edit?id=" + patient_id);
            xhttp.responseType = "json";
            xhttp.send();
        } else {


            let xhttp = new XMLHttpRequest();
            xhttp.onload = function () {
                document.write(xhttp.response);
            }
            xhttp.open("POST", "/staff/isohospital/infection/save/" + patient_id);
            // xhttp.responseType = "json";
            xhttp.send();
        }

    }

    // let buttons = document.getElementsByClassName('buttons');
    // for (let i = 0; i < buttons.length; i++) {
    //     buttons[i].addEventListener('click', () => {
    //         editUser(buttons[i].dataset.id, buttons[i].dataset.patient_id);
    //     });
    // }
}
