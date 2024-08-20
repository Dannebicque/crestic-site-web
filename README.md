# Site institutionnel du CReSTIC

Site institutionnel du CReSTIC (Centre de Recherche en STIC) de l'université de Reims Champagne Ardenne.

## Auteurs

- [@dannebicque](https://www.github.com/dannebicque)

## Licence

[![MPL 2.0 License](https://img.shields.io/badge/License-MPL2.0-green.svg)](https://choosealicense.com/licenses/mpl-2.0/)


## Installation

### Cloner le projet

```bash
  git clone https://github.com/Dannebicque/crestic-site-web.git
```

### Installer les dépendances back (Symfony)

```bash
cd crestic-site-web
composer install 
// ou update pour forcer la mise à jour
```

### Installer les dépendances front (Js/Stimulus)

```bash
yarn install //ou avec npm
```

### Compiler les assets

```bash
yarn build
```

### Configurer le projet

```bash
cp .env .env.local
```

Mettre à jour les informations de connexion à la base de données dans le fichier `.env.local`

### Configurer la base de données

```bash
php bin/console doctrine:database:create
php bin/console doctrine:schema:update -f
```

### Lancer le serveur

```bash
symfony serve //(ou via un serveur web type MAMP/LAMP)
```

L'accès se fait par exemple sur http://localhost:8888/index.php ou http://localhost:8888/public/index.php ou avec le répertoire selon la configuration de votre serveur.


