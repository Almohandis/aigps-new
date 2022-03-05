window.onload = () => {
    let doctorAddButton = document.getElementById('doctor-add-button');

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

    doctorAddButton.addEventListener('click', createDoctorInput);

}
