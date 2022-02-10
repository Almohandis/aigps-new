let elementNumber = -1;
window.onload = () => {

    //# Add phone to user
    function addPhone() {
        let phone = document.createElement('input');
        phone.type = 'text';
        phone.setAttribute('class', elementNumber);
        phone.classList.add('phone');
        phone.setAttribute('id', elementNumber);
        phone.setAttribute('placeholder', 'Phone Number');
        phone.setAttribute('name', 'phones[]');
        let label = document.createElement('label');
        label.setAttribute('for', 'phones[]');
        label.setAttribute('class', elementNumber);
        label.classList.add('phone');
        label.innerHTML = 'Phone Number';
        let br = document.createElement('br');
        let div = document.getElementById('phones');
        let deleteButton = document.createElement('input');
        deleteButton.type = 'button';
        deleteButton.setAttribute('class', elementNumber);
        deleteButton.classList.add('phone');
        deleteButton.setAttribute('id', elementNumber);
        deleteButton.addEventListener('click', deletePhone);
        elementNumber--;
        deleteButton.setAttribute('value', 'Delete');
        div.appendChild(label);
        div.appendChild(phone);
        div.appendChild(deleteButton);
        div.appendChild(br);
    }

    //# Add infection to user
    function addInfection() {
        let infection = document.createElement('input');
        infection.type = 'date';
        infection.setAttribute('class', elementNumber);
        infection.classList.add('infection');
        infection.setAttribute('id', elementNumber);
        infection.setAttribute('placeholder', 'Infection');
        infection.setAttribute('name', 'infections[]');
        let label = document.createElement('label');
        label.setAttribute('for', 'infections[]');
        label.setAttribute('class', elementNumber);
        label.classList.add('infection');
        label.innerHTML = 'Infection';
        let br = document.createElement('br');
        let div = document.getElementById('infections');
        let deleteButton = document.createElement('input');
        deleteButton.type = 'button';
        deleteButton.setAttribute('class', elementNumber);
        deleteButton.classList.add('infection');
        deleteButton.setAttribute('id', elementNumber);
        deleteButton.addEventListener('click', deleteInfection);
        elementNumber--;
        deleteButton.setAttribute('value', 'Delete');
        div.appendChild(label);
        div.appendChild(infection);
        div.appendChild(deleteButton);
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

    //# Add phone button event
    document.getElementById('add-phone').addEventListener('click', addPhone);
    document.getElementById('add-infection').addEventListener('click', addInfection);

    // let buttons = document.getElementsByClassName('buttons');
    // for (let i = 0; i < buttons.length; i++) {
    //     buttons[i].addEventListener('click', () => {
    //         editUser(buttons[i].dataset.id, buttons[i].dataset.patient_id);
    //     });
    // }
}
