# PMChat

This repository contains a very simple private messaging system which uses oauth2, slim framework/rest, Eloquent ORM, etc.

## Requirements
PHP >= 5.4.0

## Installation
* Download [`composer.phar`](https://github.com/composer/composer) 
```sh
$ curl -sS https://getcomposer.org/installer | php
```
* Dependency install
```sh
$ composer install
```
* Creating DB for testing [SQLite](http://www.sqlite.org/)
```sh
$ php share/init/init.php
```

## Usage

### DB

The DB already has 4 test users created. If you want to create another, you must login with one of them and click on the 'Register User' button.

Sample user:
```
username: user1
password: 1234
```

