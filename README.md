# Muzikaloid symfony API REST

Voici un projet back-end pour forum web en <b>Symfony v5.4</b> et <b>Docker Compose v3.7</b>

## Configuramtion

### Clonage du repo

```sh
git clone https://github.com/victorbusta/api_symfony.git
```

### installation des dependances

```sh
composer i
```

### creation de la bdd MySql

```sh
docker compose up --d
```

### configuration de la bdd

```sh
bin/console doctrine:migrations:migrate
```

### lancement du server symfony

```sh
symfony serve
```

## Acces a la documentation

Une fois le serveur lancé, la documentation OpenApi esr disponible a l'adresse suivante: http://127.0.0.1:8000/api

## Note particuliere

Ce projet est un projet non achever, il a été retranscrit en TypeScript sur ce repo : https://github.com/victorbusta/muzikaloid_backend
