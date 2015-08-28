# Repository for Laravel 5

>Repository for [Lavavel](http://laravel.com/) 5 which is used  to abstract the data layer.

## Getting Started
First, install the package through [composer](https://getcomposer.org/):
```bash
$ composer require killtw/repository
```
or add this to require section in your composer.json file:
```
"killtw/repository": "1.*"
```
And then, include the service provider whthin `config/app.php`
```php
'providers' => [
    Ontoo\Repository\Providers\RepositoryServiceProvider::class,
];
```

## Usage
### Create a repository
Create repositories through generator.
```bash
$ php artisan make:repository UserRepository
```
