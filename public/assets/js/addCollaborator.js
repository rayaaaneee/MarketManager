const formAddCollaborator = document.querySelector('.add-collaborator-form');
const statusRequestAdd = document.querySelector('.status-request-add');
const loader = document.querySelector('.loader');
const responseTextAdd = document.querySelector('.status-request-add-text');
const responseImg = responseTextAdd.querySelector('.img');

var nbRequestsSent = document.querySelectorAll('.request-sent').length;

const initTemplateCollaborator = (path, name, surname) => {
    res = document.createElement('div');
    res.classList.add('request-sent');
    console.log(name);
    console.log(surname);
    res.innerHTML = `
        <div class="request-sent-name">
            <p>•</p>
        </div>
        <a class="request-sent-cancel" title="Cancel request" href=""></a
    `;
    res.querySelector('p').textContent += ' ' + name + ' ' + surname;
    res.querySelector('a').setAttribute('href', path);
    return res;
}


formAddCollaborator.addEventListener('submit', (event) => {
    event.preventDefault();
    if (event.target.checkValidity() === false) {
        event.stopPropagation();
    } else {
        const path = event.target.getAttribute('action');
        var formData = new FormData(event.target);
        statusRequestAdd.classList.add('visible');
        loader.classList.add('visible');
        responseTextAdd.classList.remove('visible');
        addCollaborator(formData, path);
    }
});

const addCollaborator = (formData, path) => {
    $.ajax({
        url: path,
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        cache: false,
        timeout: 60000,
        success: function (data) {
            loader.classList.remove('visible');
            responseTextAdd.classList.add('visible');
            responseTextAdd.querySelector('p').textContent = data.message;
            if (data.success) {
                nbRequestsSent++;

                responseImg.classList.add('success');
                responseImg.classList.remove('error');

                let template = initTemplateCollaborator(data.cancelRequestPath, data.name, data.surname);

                let noRequestsText = document.querySelector('.no-requests');
                let requestsSentList = document.querySelector('.requests-sent-list');
                if (noRequestsText) {
                    noRequestsText.textContent = 'Requests sent (' + nbRequestsSent + ')';
                    noRequestsText.classList.remove('no-requests');
                    noRequestsText.classList.add('requests-sent-title');
                    requestsSentList.appendChild(template);
                }

            } else {
                responseImg.classList.add('error');
                responseImg.classList.remove('success');
            }
        },
        error: function (data) {
            console.log(data);
        }
    });
}