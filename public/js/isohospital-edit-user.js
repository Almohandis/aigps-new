let elementNumber = -1;
window.onload = () => {

    //# Add phone to user
    function addPhone() {
        let phone = document.createElement('input');
        phone.type = 'number';
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

    //# Add phone button event
    document.getElementById('add-phone').addEventListener('click', addPhone);
    document.getElementById('add-infection').addEventListener('click', addInfection);
}
