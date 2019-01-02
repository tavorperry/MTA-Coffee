# MTA-Coffee

## Getting started

1.Install Xampp

2.Install phpStorm editor

3.Install Composer via [https://getcomposer.org/](https://getcomposer.org/)

4.Clone the git to your xampp folder : xampp/htdocs

## First time git clone
Navigate through CMD to your project folder and run for installation your dependencies:
 ```
composer install
 ```
Change from .env.example to .env (PHPstorm user? at Refactor->Rename)

Via PhpMyAdmin, Create your DB(UTF 8) and config it at .env

Run for code key generate and create your DB for the first time
 ```
php artisan key:generate
 ```
 ```
php artisan migrate
 ```
 
Your ENV should include:
 ```angular2html
 APP_NAME=
APP_ENV=
APP_KEY=
APP_DEBUG=
APP_URL=

TZ='Asia/Jerusalem'

LOG_CHANNEL=stack

DB_CONNECTION=mysql
DB_HOST=
DB_PORT=
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=

BROADCAST_DRIVER=log
CACHE_DRIVER=file
SESSION_DRIVER=file
SESSION_LIFETIME=120
QUEUE_DRIVER=sync

MAIL_DRIVER=smtp
MAIL_HOST=smtp.mailgun.org
MAIL_PORT=
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_ENCRYPTION=
MAILGUN_DOMAIN=
MAILGUN_SECRET=

EMAIL_FROM=

GOOGLE_CLIENT_ID=
GOOGLE_CLIENT_SECRET=

LOG_PATH=

NOTIFY_TAVOR=
NOTIFY_XENIA=

Google_Analytics_id =
```

## Before starting any coding
- Don't forget to fetch at Github desktop!

- Run to insert fake data to the DB
```
php artisan db:seed
```

- Have an error? don't worry mate! try to run this command
```$xslt
composer dump-autoload
```
and than:
```
php artisan db:seed
```


