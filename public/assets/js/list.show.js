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