# Quai Antique — Backend (ECF)

API REST Symfony pour l'application **Quai Antique**, projet d'examen de certification (Diplôme Niv. 5). Expose un CRUD complet pour la gestion d'un restaurant.

## Stack technique

| Technologie | Version |
|---|---|
| PHP | 8 |
| Symfony | 5.4.* |
| Doctrine ORM | ^2.14 |
| Doctrine Migrations | ^3.2 |
| Doctrine Fixtures | ^3.4 |
| MariaDB | 10.5.8 (local) / PostgreSQL 15 (Docker) |
| NelmioApiDocBundle (Swagger) | ^4.11 |
| NelmioCorsBundle | ^2.3 |
| PHPUnit | ^9.5 |

## Installation locale

```bash
# 1. Cloner le projet
git clone https://github.com/Alizee42/backend-ecf-restaurant.git
cd backend-ecf-restaurant

# 2. Installer les dépendances
composer install

# 3. Configurer la base de données dans .env
DATABASE_URL=mysql://votreUtilisateur:votreMotDePasse@127.0.0.1:3306/db_ecf_restaurant?serverVersion=mariadb-10.5.8

# 4. Créer la base et les tables
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate

# 5. Charger les fixtures (crée le compte admin)
php bin/console doctrine:fixtures:load

# 6. Démarrer le serveur
symfony server:start
```

API disponible sur `http://localhost:8000`  
Documentation Swagger : `http://localhost:8000/api/doc`

## Connexion administrateur

```
Email    : quaiantique@admin.com
Mot de passe : 123456789@
```

## Docker (PostgreSQL)

```bash
docker-compose up -d   # Démarre PostgreSQL sur le port 5432
```

## Entités principales

`Carte`, `Categorie`, `Client`, `CompteUtilisateur`, `Employe`, `Formule`, `Horaire`, `Image`, `Menu`, `PlaceDisponible`, `Plat`, `Reservation`
