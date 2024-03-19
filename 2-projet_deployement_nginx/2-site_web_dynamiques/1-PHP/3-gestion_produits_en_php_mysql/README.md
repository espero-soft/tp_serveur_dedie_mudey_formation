# Gestion de Produits en PHP avec MySQL (CRUD)

Ce projet est une application CRUD (Create, Read, Update, Delete) de gestion de produits développée en PHP et utilisant une base de données MySQL. L'application permet de gérer les produits en effectuant différentes opérations telles que l'ajout, la modification, la suppression et l'affichage des produits.

## Fonctionnalités

- **Ajouter un produit :** Permet d'ajouter un nouveau produit avec son nom, sa description, son prix et sa quantité en stock.
- **Modifier un produit :** Permet de modifier les détails d'un produit existant tels que son nom, sa description, son prix et sa quantité en stock.
- **Supprimer un produit :** Permet de supprimer un produit de la base de données.
- **Afficher tous les produits :** Affiche la liste de tous les produits présents dans la base de données.

## Configuration requise

Avant d'exécuter l'application, assurez-vous d'avoir les éléments suivants installés sur votre système :

- Serveur web (Apache, Nginx, etc.)
- PHP version 7.0 ou ultérieure
- MySQL Server
- Un navigateur web compatible (Chrome, Firefox, etc.)

## Installation

1. Clonez ce dépôt sur votre machine locale :

   ```bash
   git clone https://github.com/votre-nom/3-gestion_produits_en_php_mysql.git
   ```

2. Importez le fichier SQL `database.sql` dans votre base de données MySQL pour créer la structure de la base de données et y insérer des données de test.

3. Configurez les paramètres de connexion à la base de données dans le fichier `config.php` situé à la racine du projet.

   ```php
   define('DB_HOST', 'localhost');
   define('DB_USERNAME', 'votre_nom_utilisateur');
   define('DB_PASSWORD', 'votre_mot_de_passe');
   define('DB_NAME', 'nom_de_votre_base_de_donnees');
   ```

4. Démarrez votre serveur web et accédez au projet via votre navigateur.

## Utilisation

Une fois l'installation terminée et que vous avez accédé au projet via votre navigateur, vous pouvez commencer à utiliser l'application de gestion des produits. Voici les étapes pour chaque fonctionnalité :

- **Ajouter un produit :** Cliquez sur le bouton "Ajouter un produit", remplissez les champs du formulaire et soumettez-le.
- **Modifier un produit :** Cliquez sur le bouton "Modifier" à côté du produit que vous souhaitez modifier, modifiez les détails dans le formulaire et soumettez-le.
- **Supprimer un produit :** Cliquez sur le bouton "Supprimer" à côté du produit que vous souhaitez supprimer.
- **Afficher tous les produits :** Tous les produits disponibles sont affichés sur la page d'accueil.

## Auteur

Ce projet a été développé par Mudey Formation.

## Contribuer

Les contributions sont les bienvenues ! Pour des suggestions d'améliorations, veuillez ouvrir une issue pour discuter des changements que vous souhaitez apporter.

## Licence

Ce projet est sous licence MIT.