pageLinks = document.querySelectorAll('.page-link');
pageLinks.forEach(function (pageLink) {
    pageLink.addEventListener('click', function (event) {
        event.preventDefault();
        var numberPage = parseInt(this.getAttribute('href'));
        var actualUrl = window.location.href;
        var url = new URL(actualUrl);
        var searchParams = new URLSearchParams(url.search);

        // Définir la valeur du paramètre "page" dans l'URL
        searchParams.set('p', numberPage);

        // Mettre à jour l'URL avec les nouveaux paramètres
        url.search = searchParams.toString();

        // Recharger la page avec la nouvelle URL
        window.location.replace(url.toString());



/*         var data = {
            page: page
        };
        var xhr = new XMLHttpRequest();
        xhr.open('GET', url + '?page=' + page, true);
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.onload = function () {
            if (xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);
                var content = document.getElementById('content');
                content.innerHTML = response.html;
            }
        };
        xhr.send(JSON.stringify(data)); */
    });
});