# BileMo

This is an API for project 7 of the PHP/Symfony course on Openclassrooms

[![Codacy Badge](https://api.codacy.com/project/badge/Grade/317330653ed34ec5917d9326b3446519)](https://www.codacy.com/manual/damientabet/BileMo?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=damientabet/BileMo&amp;utm_campaign=Badge_Grade)
[![Maintainability](https://api.codeclimate.com/v1/badges/27523fbc1fa109d4174f/maintainability)](https://codeclimate.com/github/damientabet/BileMo/maintainability)

## Processus d'installation  
### Étape 1  
Assurez-vous d'avoir Git installé et à jour sur votre machine  

www.git-scm.com  
### Étape 2

Cloner le repository sur votre serveur local  

``git clone https://github.com/damientabet/BileMo.git``  

### Étape 3

Bien s'assurer que composer est installé et à jour sur votre machine  

www.getcomposer.org/doc/00-intro.md  

### Étape 4

Après avoir installé composer, veuillez lancer ``composer install`` à la racine de votre projet.  
Toutes les dépendances vont s'installer et se stocker dans le dossier **/vendor**.

### Étape 5  

Créer la base de données en utilisant le fichier présent dans le dossier ``sql/install.sql``.  

### Étape 6  

Modifier les accès à votre base de données dans le fichier ``.env [DATABASE_URL] (l.28)``.  

### Étape 7  

Installer le logiciel Postman pour utiliser l'API.  
https://www.postman.com/downloads

### Étape 8  

Grâce à Postman, créer un nouvel utilisateur via le lien suivant : ``/register``  

### Étape 9

Vous pouvez dès à présent utiliser l'API en se référent à la documentation.  
``/doc``