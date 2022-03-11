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

    function changeCheckBox(event) {

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

        let infections_div = document.getElementById('infections');

        let div = document.createElement('div');

        let is_recovered_check = document.createElement('input');
        is_recovered_check.type = 'checkbox';
        is_recovered_check.setAttribute('class', elementNumber);
        is_recovered_check.classList.add('infection');
        is_recovered_check.setAttribute('id', elementNumber);
        // is_recovered_check.setAttribute('name', 'is_recovered[]');

        let is_recovered_hidden = document.createElement('input');
        is_recovered_hidden.type = 'hidden';
        is_recovered_hidden.value = 0;
        is_recovered_hidden.setAttribute('class', elementNumber);
        is_recovered_hidden.classList.add('infection');
        is_recovered_hidden.setAttribute('id', elementNumber);
        is_recovered_hidden.setAttribute('name', 'is_recovered[]');

        let is_recovered_label = document.createElement('label');
        is_recovered_label.setAttribute('for', 'recovery_status');
        is_recovered_label.setAttribute('class', elementNumber);
        is_recovered_label.classList.add('infection');
        is_recovered_label.innerHTML = 'Recovered';

        is_recovered_check.addEventListener('change', () => {
            let target = is_recovered_check.parentElement.querySelector('input[type=hidden]');
            if (target.value == 0) {
                target.value = 1;
            } else {
                target.value = 0;
            }
        });

        let is_recovered_div = document.createElement('div');
        is_recovered_div.appendChild(is_recovered_check);
        is_recovered_div.appendChild(is_recovered_hidden);
        is_recovered_div.appendChild(is_recovered_label);

        let has_passed_away_check = document.createElement('input');
        has_passed_away_check.type = 'checkbox';
        has_passed_away_check.setAttribute('class', elementNumber);
        has_passed_away_check.classList.add('infection');
        has_passed_away_check.setAttribute('id', elementNumber);
        // has_passed_away_check.setAttribute('name', 'has_passed_away[]');

        let has_passed_away_hidden = document.createElement('input');
        has_passed_away_hidden.type = 'hidden';
        has_passed_away_hidden.value = 0;
        has_passed_away_hidden.setAttribute('class', elementNumber);
        has_passed_away_hidden.classList.add('infection');
        has_passed_away_hidden.setAttribute('id', elementNumber);
        has_passed_away_hidden.setAttribute('name', 'has_passed_away[]');

        let has_passed_away_label = document.createElement('label');
        has_passed_away_label.setAttribute('for', 'recovery_status');
        has_passed_away_label.setAttribute('class', elementNumber);
        has_passed_away_label.classList.add('infection');
        has_passed_away_label.innerHTML = 'Passed away';

        has_passed_away_check.addEventListener('change', () => {
            let target = has_passed_away_check.parentElement.querySelector('input[type=hidden]');
            if (target.value == 0) {
                target.value = 1;
            } else {
                target.value = 0;
            }
        });

        let has_passed_away_div = document.createElement('div');
        has_passed_away_div.appendChild(has_passed_away_check);
        has_passed_away_div.appendChild(has_passed_away_hidden);
        has_passed_away_div.appendChild(has_passed_away_label);



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
        div.appendChild(is_recovered_div);
        // div.appendChild(is_recovered_check);
        // div.appendChild(is_recovered_hidden);
        // div.appendChild(is_recovered_label);
        div.appendChild(has_passed_away_div);
        // div.appendChild(has_passed_away_check);
        // div.appendChild(has_passed_away_hidden);
        // div.appendChild(has_passed_away_label);
        div.appendChild(deleteButton);
        infections_div.appendChild(div);
    }

    //# Add phone button event
    document.getElementById('add-phone').addEventListener('click', addPhone);
    document.getElementById('add-infection').addEventListener('click', addInfection);
}
