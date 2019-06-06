# Github users scrapper by keywords for repository

This project is parser for getting repositories and repository owners from Github by keywords.

Using githun REST API https://developer.github.com/v3/

## Installation

1. Install composer dependencies:
```
composer install
```

2. Create and configure .env.local (put DATABASE_URL):
```
# .env.local
DATABASE_URL=mysql://db_user:db_password@127.0.0.1:3306/db_name

```

2. Create DB and apply migrations:
```
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
```

## Running

1. First you need - getting repositories with repository owners links:

```
bin/console app:get-repositories <search word>
```

For starting with not first page:
```
bin/console app:get-repositories -p <page number> <search word>
```



