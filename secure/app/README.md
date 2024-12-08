Créer un .env.local et ajouter :

```
# bdd Windows
# DATABASE_URL="mysql://root:root@127.0.0.1:3306/M1-Symfony"

# bdd Mac
# DATABASE_URL="mysql://root:root@127.0.0.1:8889/Symfony"
```

Ensuite faire un :
```
composer install
npm install
```

Lancer votre MAMP / XAMP / LAMP

Créer la bdd :
```
php bin/console d:d:c
```

Faire les migrations :
```
php bin/console d:s:u --force
```
