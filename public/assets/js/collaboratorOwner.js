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
const menuCollabsPage = showCollabsButton.querySelector('.collaborators-menu');
const collabsPagesContainer = showCollabsButton.querySelector('.content-pages-collaborators');
const collabPageShow = collabsPagesContainer.querySelector('.collaborators-list');
const collabPageAdd = collabsPagesContainer.querySelector('.collaborator-add');

const menuCollabsLinks = menuCollabsPage.querySelectorAll('li');

menuCollabsLinks.forEach(link => {
    link.addEventListener('click', (event) => {
        event.stopPropagation();

        other = event.target.closest('ul').querySelector('.active');
        other.classList.remove('active');

        clicked = event.target.closest('li');
        clicked.classList.add('active');

        if (clicked.classList.contains('show')) {
            collabPageShow.classList.add('active');
            collabPageAdd.classList.remove('active');
        } else {
            collabPageShow.classList.remove('active');
            collabPageAdd.classList.add('active');
        }
    });
});

showCollabsButton.addEventListener('click', showCollabs);