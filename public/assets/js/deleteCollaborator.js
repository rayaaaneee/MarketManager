const redirectToDeleteCollaborator = document.querySelectorAll('.collaborator-delete');

redirectToDeleteCollaborator.forEach((collaborator) => {
    collaborator.addEventListener('click', (event) => {
        event.preventDefault();
        const path = event.target.getAttribute('href');
        deleteCollaborator(path);
    });
});

const deleteCollaborator = (path) => {
    $.ajax({
        url: path,
        type: 'POST',
        data: null,
        processData: false,
        contentType: false,
        cache: false,
        timeout: 60000,
        success: function (data) {
            console.log("succes");
        },
        error: function (data) {
            console.log("error");
        }
    });
}