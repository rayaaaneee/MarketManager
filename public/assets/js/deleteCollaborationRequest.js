const initDeleteCollaborationRequest = () => {
    let deleteCollaborationRequestButton = document.querySelectorAll('.request-sent-cancel');

    deleteCollaborationRequestButton.forEach((collaboratorButton) => {
        collaboratorButton.addEventListener('click', (event) => {
            const path = event.target.getAttribute('href');
            deleteCollaborationRequest(path, event.target);
        });
    });
}
initDeleteCollaborationRequest();

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
            if (data.success) {;
                cross.parentNode.classList.add('hidden');
                setTimeout(() => {
                    cross.parentNode.remove();
                }, 500);
                let title = document.querySelector('.requests-sent-title');
                nbRequestsSent--;
                if (nbRequestsSent >= 1) {
                    title.textContent = 'Requests sent (' + nbRequestsSent + ') :';
                    title.classList.remove('no-requests');
                    title.classList.add('requests-sent-title');
                } else {
                    title.textContent = 'No requests sent';
                    title.classList.remove('requests-sent-title');
                    title.classList.add('no-requests');
                }
            }
        },
        error: function (data) {
            console.log("error");
        }
    });
}