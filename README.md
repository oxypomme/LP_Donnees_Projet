# Nancy PI

## Développement

```sh
docker-compose up -d
docker exec -it lp_donnees_projet_php_1 php ./init-mongo.php
# Si vous voulez mongo-express (parfois il crash la première fois, va savoir pourquoi)
docker-compose up -d mongo-express
```
