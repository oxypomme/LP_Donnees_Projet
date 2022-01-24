# Nancy PI

## Développement

```sh
# Pour lancer le projet sur le port 8080
docker-compose up -d

# Pour installer les dépendances PHP
composer install
# Ou (si une erreur se produit)
docker exec -it lp_donnees_projet_php_1 sh ./composer.sh

# Pour initialiser la base de données (mongodb)
docker exec -it lp_donnees_projet_php_1 php ./init-mongo.php
# Si vous voulez mongo-express (parfois il crash la première fois, va savoir pourquoi)
docker-compose up -d mongo-express
```
