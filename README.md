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
 
 Now we have Google Auth - How great is that? 
 Add the ID and the secret code to the .env (ask me for the details):
 ```angular2html
GOOGLE_CLIENT_ID=6***********-r***************.apps.googleusercontent.com
GOOGLE_CLIENT_SECRET=vC-****************
```
Add To the ENV file also MailGun API details:
```
MAIL_USERNAME=postmaster@sandbox*************************.mailgun.org
MAIL_PASSWORD=**********************-**********-**********
MAIL_ENCRYPTION=null
MAILGUN_DOMAIN=sandbox********************************.mailgun.org
MAILGUN_SECRET=key-************************************
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


