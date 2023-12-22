# MarketManager

## Description

Ce projet est une application Web de gestion d'articles en PHP Symfony, un framework PHP basé sur le modèle MVC (modèle, vue, controlleur). Le but est ici de se créer une multitude de paniers fictifs avec des "Templates" d'articles. Cela a pour but de créer sa liste de course, il est possible de supprimer une liste, comme de collaborer dessus avec d'autres utilisateurs.

Un système de connection / enregistrement a été mis en place à cette occasion.

## Lancer le projet

Avant tout assurez vous d'avoir une version de php 8.2 ou supérieur, composer et npm installés sur votre machine

Pour lancer le projet, pensez à lancer un serveur (php -S localhost:8000) dans le dossier public

Insérer les tables situées dans assets/sql/MarketManager.sql dans votre base de données "MarketManager" pour pouvoir utiliser le projet, cela est indispensable à son bon fonctionnement.
Passez un coup de composer install puis npm install pour installer les dépendances nécéssaires au bon fonctionnement du projet

Lancez un serveur interne avec php -S localhost:8000 Vous pouvez ensuite lancer le projet en vous rendant sur localhost:8000 !
