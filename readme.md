# Projet Vente en ligne

Projet pédagogique dont le but est de revoir le paradigme de la programmation orientée objet (POO).

Développé par Charles Devif.

## Environnement de test

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

Pour les [tests réalisés](http://localhost:8080/projet-vente-en-ligne/tests.php)

## Mise en place d'un routeur

Afin de pouvoir naviguer correctement, il m'a fallu mettre à jour le fichier `apache2.conf` afin d'y ajouter un paramètre qui nous servirais à facilement parmis nos différentes vues.

De ce fait, la page d'accueil se situe a l'adresse suivante : `http://localhost:8080/projet-vente-en-ligne?p=home` ou `http://localhost:8080/projet-vente-en-ligne` ou `http://localhost:8080/projet-vente-en-ligne/index.php?p=home`.

## Collaborateurs

- Vincenzo Cusma
