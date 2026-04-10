# Touche Pas au Klaxon

Application de covoiturage inter-sites pour entreprise.

## Installation

### Prérequis
- PHP >= 8.0
- MySQL/MariaDB
- Composer
- Node.js & npm

### Étapes

1. Cloner le dépôt
```bash
git clone https://github.com/MaximeD-hub/Mise-en-place-d-une-application-MVC-en-PHP
```

2. Installer les dépendances PHP
```bash
composer install
```

3. Installer les dépendances Node
```bash
npm install
```

4. Créer la base de données
```bash
mysql -u root -p < database/klaxon.sql
```

5. Configurer la connexion (copier et adapter)
```bash
cp config/database.example.php config/database.php
```

6. Compiler le Sass
```bash
npm run build
```

7. Lancer le serveur PHP
```bash
php -S localhost:8000 -t public
```

## Comptes de test

### Administrateur
- Email: admin@email.fr
- Mot de passe: Admin123!

### Utilisateur
- Email: alexandre.martin@email.fr
- Mot de passe: Password123!

## Tests

```bash
composer test
composer phpstan
```

## Technologies

- PHP 8+
- MySQL/MariaDB
- Bootstrap 5
- Sass
- PHPUnit
- PHPStan