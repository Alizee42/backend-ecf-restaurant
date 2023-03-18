###  Backend-ecf-restaurant

- [x] PHP8
- [x] Symfony 5.4
- [x] MariaDB-10.5.8

# Heroku API
https://backend-restaurant-ecf.herokuapp.com/api/doc

![Quai Antique API](https://raw.githubusercontent.com/Alizee42/frontend-ecf-restaurant/main/src/assets/images/logo/logo3.jpg)

#### Installation En local

###### Etape 1: Cloner le projet back-end
[Download](https://github.com/Alizee42/backend-ecf-restaurant)
```
git clone https://github.com/Alizee42/backend-ecf-restaurant.git
```

###### Etape 2: Installer les dependences
Ouvrir le terminal dans le projet backend-ecf-restaurant
Ensuite lancer la commande
``` composer install
```

###### Etape 3: Configuration et installation de la base de donnée
Modifier les accès a la base de données(mettre votre nom utilisateur et votre mot de passe en local) dans le ficher .env
``` 
DATABASE_URL=mysql://votreNomUtilisateur:votreMotDepasse@127.0.0.1:3306/db_ecf_restaurant?serverVersion=mariadb-10.5.8
``` 

###### Etape 4: Créer votre base de données et générer les tables
Taper la commande dans le terminale
"php bin/console doctrine:database:create"
Ensuite la commande suivante
"php bin/console doctrine:migrations:migrate"

###### Etape 5: Générer l'utilisateur Admin
Saisir la commande dans le terminal
``` 
php bin/console doctrine:fixtures:load
``` 

###### Etape 6: Demarrer le projet
Saisir la commande
``` 
symfony server:start
``` 