window.onload = () => {
    let doctorCounter = 0;
    let addressElement = document.getElementById('addressLabel');
    let doctorAddButton;

    function createDoctorInput() {
        let doctorInput = document.createElement('input');
        doctorInput.setAttribute('type', 'number');
        doctorInput.setAttribute('name', 'doctors[]');
        doctorInput.setAttribute('class', 'form-control');
        doctorInput.setAttribute('placeholder', 'Enter doctor\'s ID');
        doctorInput.setAttribute('required', '');
        doctorInput.setAttribute('class', 'new-doctor');
        doctorAddButton.insertAdjacentElement('beforebegin', doctorInput);
    }


    document.getElementById('type').addEventListener('change', () => {
        let type = document.getElementById('type').value;
        if (type === 'Vaccination' && doctorCounter === 0) {
            doctorCounter++;
            let doctorLabel = document.createElement('label');
            doctorLabel.setAttribute('for', 'doctors');
            doctorLabel.setAttribute('class', 'new-doctor');
            doctorLabel.innerHTML = 'Doctors';
            document.getElementById('type')
            doctorAddButton = document.createElement('input');
            doctorAddButton.setAttribute('type', 'button');
            doctorAddButton.setAttribute('id', 'add-doctor');
            doctorAddButton.setAttribute('value', 'Add doctor');
            doctorAddButton.setAttribute('class', 'new-doctor');
            addressElement.insertAdjacentElement('beforebegin', doctorLabel);
            addressElement.insertAdjacentElement('beforebegin', doctorAddButton);
            doctorAddButton.addEventListener('click', createDoctorInput);
        } else if (doctorCounter) {
            doctorAddButton.removeEventListener('click', createDoctorInput);
            let deleteElements = document.getElementsByClassName('new-doctor');
            while (deleteElements[0]) {
                deleteElements[0].parentNode.removeChild(deleteElements[0]);
            }
            doctorCounter = 0;
        }
    });
}
