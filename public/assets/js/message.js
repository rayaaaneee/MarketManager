var crossClicked = false;

const disappearMessage = (message) => {
    message.classList.add('disappear');
    setTimeout(() => {
        message.style.display = 'none';
    }, 1000);
}

const clickCross = (event) => {
    const message = event.target.parentElement;
    disappearMessage(message);
    crossClicked = true;
}

const naturalDisappear = (message) => {
    setTimeout(() => {
        if (!crossClicked){
            disappearMessage(message);
        }
    }, 3000);
}

const message = document.querySelector('.alert');
naturalDisappear(message);