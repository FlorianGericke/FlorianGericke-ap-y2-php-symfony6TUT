# Symfony 6 Tutorial

Simple Learning project for Symfony 6.

Tutorial Course from Traversy Media on [YouTube](https://www.youtube.com/playlist?list=PLillGF-Rfqba-PQBBEf14-fi6LafvvDYS).

## How to start dev environment
```shell
    $npm run watch
    $symfony server:start
```


## How to add new Entities via command line
```shell
    $php bin/console make:entity
    $php bin/console make:migration
    $php bin/console doctrine:migrations:migrate
```

## Run SQL Query with Doctrine in the command line
```shell
    $php bin/console doctrine:query:sql 'select * from article'
```
