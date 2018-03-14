# Kafe_Emon

##Getting started

1.Install Xampp

2.Install phpStorm editor

3.Install Composer via[https://getcomposer.org/](https://getcomposer.org/)

4.Clone the git to your xampp folder : xampp/htdocs

##First time git clone
Run for installation your dependencies
 ```
composer install
 ```
Change from .env.example to .env (PHPstorm user? at Refactor->Rename)

Create your DB and config it at .env

Run for code key generate and create your DB for the first time
 ```
php artisan key:generate
 ```
 ```
php artisan migrate
 ```

##Before starting any coding
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


