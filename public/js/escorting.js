window.onload = () => {
    function confirmEscorting(id) {
        const xhttp = new XMLHttpRequest();
        xhttp.onload = function () {
            if (xhttp.responseText == 1) {
                if (document.querySelector(`[data-id="${id}"]`).value == "Escort") {
                    document.querySelector(`[data-id="${id}"]`).value = "Undo escorting";
                } else if (document.querySelector(`[data-id="${id}"]`).value == "Undo escorting") {
                    document.querySelector(`[data-id="${id}"]`).value = "Escort";
                }
            } else if (xhttp.responseText == 0) {
                alert("Something went wrong, please try again");
            }
        }
        xhttp.open("GET", "/staff/moia/modify?id=" + id + `&status=${document.querySelector(`[data-id="${id}"]`).value}`);
        xhttp.send();
    }

    let buttons = document.getElementsByClassName('buttons');
    for (let i = 0; i < buttons.length; i++) {
        buttons[i].addEventListener('click', () => {
            confirmEscorting(buttons[i].dataset.id);
        });
    }
}
