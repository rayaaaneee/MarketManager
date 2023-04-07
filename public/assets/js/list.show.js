var lastForm = null;

const switchButton = (event) => {
    const button = event.currentTarget;
    const buttonsContainer = button.parentElement;
    const otherButton = buttonsContainer.querySelector("*.switched");
    const form = button.closest('form');
    
    if (lastForm !== null) {
        disappearInputs(event, lastForm);
    }
    lastForm = form;
    appearInputs(form);
    
    otherButton.classList.remove('switched');
    button.classList.add('switched');
};

const appearInputs = (form) => {
    const inputs = form.querySelectorAll('input');
    inputs.forEach(input => {
        input.classList.toggle('switched');
    });
    const labels = form.querySelectorAll('.list-property-value');
    labels.forEach(label => {
        label.classList.toggle('switched');
    });
    const cross = form.querySelector('.close-modification-article');
    cross.classList.add('active');
    const deleteButton = form.querySelector('.delete-article-in-list');
    deleteButton.classList.add('active');
}

const disappearInputs = (event, form = null) => {
    event.preventDefault();
    let cross;
    if (form === null) {
        cross = event.currentTarget;
        form = cross.closest('form');
        lastForm = null;
    } else {
        cross = form.querySelector('.close-modification-article');
        form = cross.closest('form');
    }
    let deleteButton = form.querySelector('.delete-article-in-list');
    const inputs = form.querySelectorAll('input');

    inputs.forEach(input => {
        input.classList.add('switched');
    });
    const labels = form.querySelectorAll('.list-property-value');
    labels.forEach(label => {
        label.classList.remove('switched');
    });

    const buttonsContainer = form.querySelector('.article-modify-container');
    const button = buttonsContainer.querySelector("*:not(.switched)");
    const otherbutton = buttonsContainer.querySelector("*.switched");

    button.classList.add('switched');
    otherbutton.classList.remove('switched');

    cross.classList.remove('active');
    deleteButton.classList.remove('active');
}

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