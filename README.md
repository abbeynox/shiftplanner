# Schichtplan

This is a very simple shift planer. An admin can define a plan with shifts and users can subscribe to one or more shifts. It can help to organize parties, festivals or political events. 

## About Schichtplan

Schichtplan was original developed by [o](https://code.immerda.ch/o) with [cakephp](https://book.cakephp.org/1.3/en/index.html) framework back in 2011. The current version use [laravel](https://github.com/laravel/framework) as a base and is compatible with modern php version (^7.3|^8.0). 

## Installation

You need to install the dependencies to run schichtplaner.
```bash
./setup.sh
```

## Configure
To run schichtplan you need to configure a database and a mail backend. You can choose between different database vendors such as mysql, postgres or sqlite (see also [laravel doc](https://github.com/laravel/framework)). Add a `.env` file with your configuration and credentials.

Please change the APP_KEY. The easiest way to change the app_key is to run `php artisan key:generate`. This will set the APP_KEY in your .env file

```dotenv
APP_NAME=Schichtplan
APP_ENV=production
APP_KEY=base64:YOU_NEED_TO_CHANGE_ME
APP_DEBUG=false
APP_URL=https://schichtplan.com
LOG_LEVEL=info
APP_API_KEY=the key to trigger cronjobs

DB_CONNECTION=sqlite
DB_DATABASE=/path/to/laravel/database/database.sqlite
DB_FOREIGN_KEYS=true

MAIL_MAILER=smtp
MAIL_HOST=mailhog
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=null
MAIL_FROM_NAME="${APP_NAME}"
```

After you generated the APP_KEY and configured your database connection, you have to run the databse migrations. This will setup or migrate needed database tables.

```bash
# Install or upgrade database tables
php artisan migrate
```

You should register a cronjob to cleanup plans without activity. For more information see the [laravel documentation](https://laravel.com/docs/8.x/scheduling) 
```bash
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1```
```
## Upgrade
There is no upgrade path from older version of schichtplan (< 2.0).

## Commands
There is a command to clean up old plans. Most of the time you want to run this in a schedule and don't need to invoke it directly.
```bash
php artisan schichtplan:cleanup
```

There is a command to send notification emails to subscribers one day before the event.
```bash
php artisan schichtplan:notify-subscribers
```

## Development
If you find errors please open an issue or send a pull request!

To start devloping, clone the repo, install the dependencies and copy the `.env.example` to .env. You want to check the values in the `.env` file, before starting to develop.

You need the frontend dependencies as well.
```bash
# install frontedn dependencies (CSS/Bootstrap/JS)
npm install
# Build frontend assets
npm run dev
```

```bash
# run dev server
php artisan serve
```

If you change the design make sure you also commit the built assets.
```bash
# Build production assets
npm run prod
```

## Containerized development env

```bash
./setup.sh
CR=podman
$CR run --rm --env-file=.env --net=host -p 8000:8000 -it -v .:/app docker.io/library/php:8 bash -c "cd /app && php artisan serve"
```

## License

Schichtplan is free software and under [AGPL license](https://www.gnu.org/licenses/agpl-3.0.en.html)

[Laravel](https://laravel.com) is Opensource software and under [MIT-License](https://opensource.org/licenses/MIT).

[Flatpickr](https://opensource.org/licenses/MIT) is opensource software and under [MIT_license](https://opensource.org/licenses/MIT)

[Tailwindcss](https://github.com/tailwindlabs/tailwindcss) is opensource software and under [MIT_license](https://opensource.org/licenses/MIT)
