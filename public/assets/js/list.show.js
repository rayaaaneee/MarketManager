const switchButton = (event) => {
    const button = event.currentTarget;
    const buttonsContainer = button.parentElement;
    const otherButton = buttonsContainer.querySelector("*.switched");
    
    appearInputs(button.closest('form'));
    
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
}

const disappearInputs = (event) => {
    event.preventDefault();
    const cross = event.currentTarget;
    const form = cross.closest('form');
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
}