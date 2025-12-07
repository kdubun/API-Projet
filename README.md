# Projet Symfony – API, CRUD et Front.
## Description

### Ce projet inclut :
Une API REST : `/api/tasks`  
Un CRUD web classique : `/task`  
Une interface front consommant l’API : `/task/front`  
Une base de données SQLite pour une installation simple

## Installation  
### Récupération du projet
```
git clone https://github.com/<UTILISATEUR>/<REPO>.git
cd API-Projet
composer install
```

### Base de données
```
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate -n
```

### Lancement du serveur
```
symfony serve
```

## Fonctionnalités

### CRUD Web  
Liste : `/task`  
Création : `/task/new`  
Détail : `/task/{id}`  
Modification : `/task/{id}/edit`  
Suppression : POST `/task/{id}`  

### API REST
Endpoints :
```
GET    /api/tasks
GET    /api/tasks/{id}
POST   /api/tasks
PUT    /api/tasks/{id}
DELETE /api/tasks/{id}
```

Exemple JSON :
```
{
  "title": "Exemple",
  "description": "Description",
  "isDone": false
}
```

### Interface Front  
Accessible à l’adresse : `/task/front`

Fonctionnalités :  
Création de tâches  
Liste dynamique  
Mise à jour du statut  
Suppression  

## Tests rapides  
CRUD web : accéder à `/task`  
API : tester les 5 endpoints via Postman ou curl  
Front : `/task/front` (ajout, mise à jour, suppression)  

## Structure du projet
```
src/Controller/
  ApiTaskController.php
  TaskController.php

templates/task/
  index.html.twig
  new.html.twig
  edit.html.twig
  front.html.twig

config/routes/
  task_crud.yaml
  task_front.yaml
```
