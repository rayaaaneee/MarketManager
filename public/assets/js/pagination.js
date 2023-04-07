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
    });
});