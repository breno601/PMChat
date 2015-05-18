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

### Pasta *Core* e arquivo *routes.php*

A pasta `Core` e o arquivo `routes.php` é onde deve estar todo o fluxo do projeto. Nestes locais ficarão os código que não devem ser atualizados por novas versões do projeto `Slim-OAuth2-Eloquent`.
Para não haver problemas é muito importante que o desenvolvedor inclua estes no `.gitignore` de seu projeto.

### Solicitar um token para acesso e atualizar token (Refresh token)

Para obter um token de acesso ou atualizar o token existente, a solicitão deve ser feita utilizando o método `POST` e `Content-Type: application/x-www-form-urlencoded`. Os dados nescessários são:
  
##### Solicitação
```
grant_type: password
client_id: testclient
client_secret: secret
username: usertest
password: test
```
  
##### Atualização
```
grant_type: password
client_id: testclient
client_secret: secret
username: usertest
password: test
```

### Acessar dados com token de acesso obtido na solitação (Access token)

O acesso aos dados da API acontece dentro dos padrões *RESTful* (`GET`, `POST`, `PUT`, `DELETE`). Ao utilizar qualquer um destes métodos é obrigatório o envio do 'token' obtido na solictação. O mesmo precisa ser enviado no 'header' da requisição 'http' através do parametro 'Authorization' e este deve ser da seguinte foma:

```
Authorization: Bearer d7TSwi1dXK3F1sN78tTEPDGOmD9c2oWmRFu6hrj6
```

*OBS.: O hash utilizado como token é meramente ilustrativo, devendo ser substituído pelo obtido na solicitação/atualização de token*

## Links
* [Slim Framework](http://www.slimframework.com/)
* [Eloquent ORM](http://laravel.com/docs/4.2/eloquent#)
* [OAuth](http://oauth.net/)
* [Slim-Monolog](https://github.com/Flynsarmy/Slim-Monolog)
* [Composer](https://github.com/composer/composer)
* [SQLite](http://www.sqlite.org/)
* [PHP](http://php.net/)
* [oauth2-server](https://github.com/thephpleague/oauth2-server)

## Referências utilizadas
* [Best Practices for Designing a Pragmatic RESTful API](http://www.vinaysahni.com/best-practices-for-a-pragmatic-restful-api)
* [An Introduction to OAuth 2](http://www.slideshare.net/aaronpk/an-introduction-to-oauth-2)
* [RFC3986](http://www.ietf.org/rfc/rfc3986.txt)

## Suporte
Bugs, features, sugestões ou dúvidas utilizar [GitHub](https://github.com/leoniralves/Slim-OAuth2-Eloquent/issues)