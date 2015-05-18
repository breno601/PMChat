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
username: usertest
password: test
```

### Access/ask for a permission token

To obtain an access token you must perform a 'POST' (using Firefox's REST Easy extension for example) putting:

as header:
`Content-Type: application/x-www-form-urlencoded`

as data:
grant_type: password
client_id: testclient
client_secret: secret
username: usertest
password: test


The execution of the request will return a JSON text containing the authorization token. Example:
{"access_token":"Em7YdaLlFNqrri84S2WGDP4V1DYfgYQtqqtH2nzc","token_type":"Bearer","expires_in":3600,"refresh_token":"ox0WJSviZmtNXwtRWFjaIWHYw7hMZgKIlOjw0HL2"}

After that you can do tests by performing GET or POST requests putting always the following header:
'Authorization' : 'Bearer token'    (Example: 'Authorization': 'Bearer Em7YdaLlFNqrri84S2WGDP4V1DYfgYQtqqtH2nzc' )

You can test by sending a GET Request to yourserver/public/api/v1/messages with the above header. It will return all the messages the system has.


## Links
* [Slim Framework](http://www.slimframework.com/)
* [Eloquent ORM](http://laravel.com/docs/4.2/eloquent#)
* [OAuth](http://oauth.net/)
* [Composer](https://github.com/composer/composer)
* [SQLite](http://www.sqlite.org/)
* [PHP](http://php.net/)
* [oauth2-server](https://github.com/thephpleague/oauth2-server)


## Author
Breno / breno601 [at] gmail.com
