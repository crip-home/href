# href
Link blog to share with world


## Development

- Run tests:

        phpunit

- Generate model docs: 

        php artisan --nowrite ide-helper:models

- Generate raw sql for migration

        php artisan migrate --pretend > deploy/migrate.sql
