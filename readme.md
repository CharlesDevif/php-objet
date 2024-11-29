# Projet Vente en ligne

Projet pédagogique dont le but est de revoir le paradigme de la programmation orientée objet (POO).

Développé par Charles Devif & Vincenzo Cusma.

## Environnement de développement / test

Il est impératif d'utiliser `Docker` pour exécuter cet environnement.

Resources utiles :

- [Docker on Linux](https://docs.docker.com/desktop/setup/install/linux/)
- [Docker on Windows](https://docs.docker.com/desktop/setup/install/windows-install/)
- [Docker on Mac](https://docs.docker.com/desktop/setup/install/mac-install/)

Une fois cela fait, il vous suffit d'exécuter les commandes suivantes à la racine du projet :

```bash
cd docker/ && docker-compose up -d
```

> Concernant toutes commandes relatives à `docker-compose`, celles-ci devront être exécutées dans le dossier **docker**.

Pour arrêter l'exécution des conteneurs et les supprimer : `docker-compose down`.

Pour simplement les arrêter : `docker-compose stop`

Pour les relancer : `docker-compose start`.

Une fois les conteneurs lancés, il suffit de vous rendre sur le [lien suivant](http://localhost:8080/projet-vente-en-ligne/).

- Pour les [tests réalisés](http://localhost:8080/projet-vente-en-ligne/test)
- Pour [PHPMyAdmin](http://localhost:8081/).

## Fonctionnalités non implémentées

- Panel d'administration
- IHM / Controller du paiement
- Gestion complète du fichier de la classe **ProduitNumérique** (ajout seulement, et lors d'une modification, nécessite obligatoirement d'ajouter un nouveau fichier).
