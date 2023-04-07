const deleteCollaborationRequestButton = document.querySelectorAll('.request-sent-cancel');

deleteCollaborationRequestButton.forEach((collaboratorButton) => {
    collaboratorButton.addEventListener('click', (event) => {
        event.preventDefault();
        const path = event.target.getAttribute('href');
        deleteCollaborationRequest(path, event.target);
    });
});

const deleteCollaborationRequest = (path, cross) => {
    $.ajax({
        url: path,
        type: 'POST',
        data: null,
        processData: false,
        contentType: false,
        cache: false,
        timeout: 60000,
        success: function (data) {
            if (data.success) {
                console.log("success");
                console.log(cross);
                throw new Error("test");
                cross.parentNode.classList.add('hidden');
                setTimeout(() => {
                    cross.parentNode.remove();
                }, 500);
            }
        },
        error: function (data) {
            console.log("error");
        }
    });
}