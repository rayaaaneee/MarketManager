const redirectToDeleteCollaborator = document.querySelectorAll('.collaborator-delete');
const titleCollaborators = document.querySelector('.collaborators-title');
var nbCollaborators = document.querySelectorAll('.collaborator').length;

redirectToDeleteCollaborator.forEach((collaborator) => {
    collaborator.addEventListener('click', (event) => {
        event.preventDefault();
        const path = event.target.getAttribute('href');
        deleteCollaborator(path, event.target);
    });
});

const deleteCollaborator = (path, cross) => {
    $.ajax({
        url: path,
        type: 'POST',
        data: null,
        processData: false,
        contentType: false,
        cache: false,
        timeout: 60000,
        success: function (data) {
            cross.parentNode.classList.add('hidden');
            nbCollaborators--;
            if (nbCollaborators === 0) {
                titleCollaborators.textContent = 'You have no collaborators';
                titleCollaborators.classList.remove('collaborators-title');
                titleCollaborators.classList.add('no-collaborators');
            } else {
                titleCollaborators.textContent = 'Collaborators (' + nbCollaborators + ') :';
                titleCollaborators.classList.remove('no-collaborators');
                titleCollaborators.classList.add('collaborators-title');
            }
            setTimeout(() => {
                cross.parentNode.remove();
            }, 500);
        },
        error: function (data) {
            console.log("error");
        }
    });
}