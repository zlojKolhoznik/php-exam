let buttons = document.querySelectorAll('button[data-bs-toggle="collapse"]');
let activeButtonId = null;

function hideShownCollapse(pressedId) {
    if (activeButtonId == pressedId) {
        activeButtonId = null;
        return;
    }
    if (activeButtonId != null) {
        let button = document.getElementById(activeButtonId);
        button.click();
    }
    activeButtonId = pressedId;
}

buttons.forEach(button => button.addEventListener('click', e => hideShownCollapse(e.target.id)));