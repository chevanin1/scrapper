# Github users scrapper by keywords for repository

This project is parser for getting repositories and repository owners from Github by keywords.

Using githun REST API https://developer.github.com/v3/

## Installation

1. Create and configure .env.local (put DATABASE_URL):
```
# .env.local
DATABASE_URL=mysql://db_user:db_password@127.0.0.1:3306/db_name

```

2. Install composer dependencies:
```
composer install
```

3. Create DB and apply migrations:
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

2. After that you need to get repos owners:
```
bin/console app:get-users
```

Owner pages will be requested only for repos in DB without owner relation, e.g. - will not be loaded twice.

There is limit on request to Github owners - 60 per hour.