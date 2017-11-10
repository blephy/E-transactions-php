# Intégration Paiement E-transactions
Projet concernant l'intégration d'un système de paiement en ligne entre commercant et e-transactions, la solution de paiement en ligne du Crédit Agricole.

Projet du [Centre de Pathologie Haut de France](https://www.anapath.fr).
Voir aussi la [documentation E-transactions officielle](https://www.e-transactions.fr/pages/global.php?page=telechargement).

Sans autorisation écrite de la part du [Centre de Pathologie Haut de France](https://www.anapath.fr), vous n'êtes aucunement en droit d'utiliser, reproduire, commercialiser, ou modifier ce projet.

L'interface utilisateur est développée avec VueJS, permet de faire des requètes HTTP sur une API qui vous renvoie le montant de la facture en fonction des variables envoyées (ici la date de naissance du patient et la référence de l'examen') ([dossier /src](src/)).
La gestion de la communication avec e-transactions est gérée en PHP ([dossier brique/](brique/)).

## Installation & build de l'interface utilisateur VueJS

``` bash
# Installation des dépendances pour l'interface utilisateur
npm install

# Lance le server de développement sur localhost:8080
npm run dev

# build le projet avec minification
npm run build

# build le projet avec minification et montre un rapport de build
npm run build --report
```
Pour plus de détail concernant VueJS: [guide](http://vuejs-templates.github.io/webpack/) et [docs for vue-loader](http://vuejs.github.io/vue-loader).

## Personnalisation de la solution PHP
Vous pouvez personnaliser votre propre solution, notamment la communication avec e-transactions.
Configurer votre solution dans les fichiers:

Configuration de vos variables client e-transactions
> [brique/config/client.php](brique/config/client.php)

Configuration des url d'appels e-transactions
> [brique/config/e-transactions.php](brique/config/e-transactions.php)

Configuraton de vos clé HMAC (Production et Pré-Production)
> [brique/config/hmac.php](brique/config/hmac.php)

Pour faire fonctionner la gestion interface client <-> e-transactions, vous aurez besoin de faire tourner un serveur HTTP, comme [Nginx](https://nginx.org/en/) ou [Apache](https://httpd.apache.org/) configurer pour executer PHP 7+.
