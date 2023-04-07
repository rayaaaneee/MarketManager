const showCollabs = (event) => {
    event.stopPropagation();
    showCollabsButton.classList.add('active');
    showCollabsButton.removeAttribute('title');
    showCollabsButton.removeEventListener('click', showCollabs);
    closeShowCollabsButton.addEventListener('click', closeCollabs);
}

const closeCollabs = (event) => {
    event.stopPropagation();
    showCollabsButton.classList.remove('active');
    showCollabsButton.setAttribute('title', showCollabsButtonTitle);
    closeShowCollabsButton.removeEventListener('click', closeCollabs);
    showCollabsButton.addEventListener('click', showCollabs);
}

const showCollabsButton = document.querySelector('#collaborators');
const showCollabsButtonTitle = showCollabsButton.getAttribute('title');
const closeShowCollabsButton = showCollabsButton.querySelector('.collaborators-cross-page');

showCollabsButton.addEventListener('click', showCollabs);