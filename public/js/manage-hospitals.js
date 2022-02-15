window.onload = () => {

    //# Track changed hospitals
    let isolation = document.querySelectorAll('input[type=number]');
    let ids = document.querySelectorAll('input[type=hidden].id');
    for (let i = 0; i < isolation.length; i++) {
        isolation[i].addEventListener('change', () => {
            isolation[i].setAttribute('class', 'changed');
            ids[i].classList.add('changed');
        });
    }

    //# Submit only changed hospitals
    document.querySelector('input[type=submit]').addEventListener('click', () => {
        let isolation = document.querySelectorAll('input[type=number]:not(.changed)');
        let ids = document.querySelectorAll('input[type=hidden].id:not(.changed)');
        for (let i = 0; i < isolation.length; i++) {
            isolation[i].setAttribute('disabled', true);
            ids[i].setAttribute('disabled', true);
        }
    });
}
