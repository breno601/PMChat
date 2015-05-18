<?php

namespace RelationalExample\Config;

include __DIR__.'/../../vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule();

$capsule->addConnection([
    'driver'    => 'sqlite',
    'database'  => __DIR__.'/oauth2.sqlite3',
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
]);

$capsule->setAsGlobal();

@unlink(__DIR__.'/oauth2.sqlite3');
touch(__DIR__.'/oauth2.sqlite3');

Capsule::statement('PRAGMA foreign_keys = ON');

/******************************************************************************/


print 'Creating users table'.PHP_EOL;

Capsule::schema()->create('users', function ($table) {
    $table->increments('id');
    $table->string('username');
    $table->string('password');
    $table->string('name');
    $table->string('email');
    $table->string('photo');
});

print 'Creating users samples'.PHP_EOL;

Capsule::table('users')->insert([
    'username'  =>  'usertest',
    'password'  =>  password_hash('test', PASSWORD_DEFAULT),
    'name'      =>  'Paul McCartney',
    'email'     =>  'email@restful.co.uk',
    'photo'     =>  'img/paul.png',
]);

Capsule::table('users')->insert([
    'username'  =>  'usertest2',
    'password'  =>  password_hash('test', PASSWORD_DEFAULT),
    'name'      =>  'Bob Dylan',
    'email'     =>  'email2@restful.co.uk',
    'photo'     =>  'img/bob.png',
]);

Capsule::table('users')->insert([
    'username'  =>  'usertest3',
    'password'  =>  password_hash('test', PASSWORD_DEFAULT),
    'name'      =>  'James Hetfield',
    'email'     =>  'email3@restful.co.uk',
    'photo'     =>  'img/james.png',
]);

Capsule::table('users')->insert([
    'username'  =>  'usertest4',
    'password'  =>  password_hash('test', PASSWORD_DEFAULT),
    'name'      =>  'Axl Rose',
    'email'     =>  'email3@restful.co.uk',
    'photo'     =>  'img/axl.png',
]);

Capsule::table('users')->insert([
    'username'  =>  'usertest5',
    'password'  =>  password_hash('test', PASSWORD_DEFAULT),
    'name'      =>  'Slash',
    'email'     =>  'email3@restful.co.uk',
    'photo'     =>  'img/slash.png',
]);

print 'Creating messages table'.PHP_EOL;

Capsule::schema()->dropIfExists('messages');
Capsule::schema()->create('messages', function ($table) {
    $table->increments('id');
    $table->string('to_id')->unsigned();
    $table->string('from_id');
    $table->string('title')->nullable();
    $table->string('message')->nullable();
    $table->nullableTimestamps();
    $table->foreign('to_id')->references('id')->on('users')->onDelete('cascade');
});

print 'Creating messages samples'.PHP_EOL;

Capsule::table('messages')->insert([
    'from_id'  =>  '1',
    'to_id'  =>  '2',
    'title'  =>  'Hi from Brazil',
    'message'      =>  'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam sagittis tellus eu congue sodales. Fusce at sem hendrerit nibh viverra porta volutpat ac sem. Donec elementum tristique pharetra. Quisque ullamcorper viverra nulla sit amet hendrerit. Nam et pellentesque nisi.',
    "created_at"=> "2015-05-14 17:52:36",
    "updated_at"=> "2015-05-14 17:52:36"
]);
Capsule::table('messages')->insert([
    'from_id'  =>  '1',
    'to_id'  =>  '3',
    'title'  =>  'Hi from South America',
    'message'      =>  'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam sagittis tellus eu congue sodales. Fusce at sem hendrerit nibh viverra porta volutpat ac sem. Donec elementum tristique pharetra. Quisque ullamcorper viverra nulla sit amet hendrerit. Nam et pellentesque nisi.',
    "created_at" => "2015-05-14 18:52:36",
    "updated_at" => "2015-05-14 18:52:36"

]);
Capsule::table('messages')->insert([
    'from_id'  =>  '2',
    'to_id'  =>  '1',
    'title'  =>  'Hi from Minas Gerais!',
    'message'      =>  'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam sagittis tellus eu congue sodales. Fusce at sem hendrerit nibh viverra porta volutpat ac sem. Donec elementum tristique pharetra. Quisque ullamcorper viverra nulla sit amet hendrerit. Nam et pellentesque nisi.',
    "created_at" => "2015-05-14 19:52:36",
    "updated_at" => "2015-05-14 19:52:36"
]);
Capsule::table('messages')->insert([
    'from_id'  =>  '3',
    'to_id'  =>  '1',
    'title'  =>  'Hi from Belo Horizonte!',
    'message'      =>  'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam sagittis tellus eu congue sodales. Fusce at sem hendrerit nibh viverra porta volutpat ac sem. Donec elementum tristique pharetra. Quisque ullamcorper viverra nulla sit amet hendrerit. Nam et pellentesque nisi.',
    "created_at" => "2015-05-14 20:52:36",
    "updated_at" => "2015-05-14 20:52:36"
]);
Capsule::table('messages')->insert([
    'from_id'  =>  '3',
    'to_id'  =>  '2',
    'title'  =>  'Hi from Rio de Janeiro!',
    'message'      =>  'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam sagittis tellus eu congue sodales. Fusce at sem hendrerit nibh viverra porta volutpat ac sem. Donec elementum tristique pharetra. Quisque ullamcorper viverra nulla sit amet hendrerit. Nam et pellentesque nisi.',
    "created_at" => "2015-05-14 20:52:36",
    "updated_at" => "2015-05-14 20:52:36"
]);
Capsule::table('messages')->insert([
    'from_id'  =>  '2',
    'to_id'  =>  '1',
    'title'  =>  'Title of message',
    'message'      =>  'This is a test to see whether the component is working!',
    "created_at" => "2015-05-14 21:52:36",
    "updated_at" => "2015-05-14 21:52:36"
]);

Capsule::table('messages')->insert([
    'from_id'  =>  '4',
    'to_id'  =>  '1',
    'title'  =>  'Hi from Europe!',
    'message'      =>  'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam sagittis tellus eu congue sodales. Fusce at sem hendrerit nibh viverra porta volutpat ac sem. Donec elementum tristique pharetra. Quisque ullamcorper viverra nulla sit amet hendrerit. Nam et pellentesque nisi.',
    "created_at" => "2015-05-14 21:52:36",
    "updated_at" => "2015-05-14 21:52:36"
]);

Capsule::table('messages')->insert([
    'from_id'  =>  '5',
    'to_id'  =>  '1',
    'title'  =>  'Hi from Amsterdam!',
    'message'      =>  'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam sagittis tellus eu congue sodales. Fusce at sem hendrerit nibh viverra porta volutpat ac sem. Donec elementum tristique pharetra. Quisque ullamcorper viverra nulla sit amet hendrerit. Nam et pellentesque nisi.',
    "created_at" => "2015-05-14 21:52:36",
    "updated_at" => "2015-05-14 21:52:36"
]);

Capsule::table('messages')->insert([
    'from_id'  =>  '1',
    'to_id'  =>  '1',
    'title'  =>  'Hi from Low Countries!',
    'message'      =>  'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam sagittis tellus eu congue sodales. Fusce at sem hendrerit nibh viverra porta volutpat ac sem. Donec elementum tristique pharetra. Quisque ullamcorper viverra nulla sit amet hendrerit. Nam et pellentesque nisi.',
    "created_at" => "2015-05-14 21:52:36",
    "updated_at" => "2015-05-14 21:52:36"
]);
/******************************************************************************/

print 'Creating clients table'.PHP_EOL;

Capsule::schema()->create('oauth_clients', function ($table) {
    $table->string('id');
    $table->string('secret');
    $table->string('name');
    $table->primary('id');
});

Capsule::table('oauth_clients')->insert([
    'id'        =>  'testclient',
    'secret'    =>  'secret',
    'name'      =>  'Test Client',
]);

/******************************************************************************/

print 'Creating client redirect uris table'.PHP_EOL;

Capsule::schema()->create('oauth_client_redirect_uris', function ($table) {
    $table->increments('id');
    $table->string('client_id');
    $table->string('redirect_uri');
});

Capsule::table('oauth_client_redirect_uris')->insert([
    'client_id'     =>  'testclient',
    'redirect_uri'  =>  'http://example.com/redirect',
]);

/******************************************************************************/

print 'Creating scopes table'.PHP_EOL;

Capsule::schema()->create('oauth_scopes', function ($table) {
    $table->string('id');
    $table->string('description');
    $table->primary('id');
});

Capsule::table('oauth_scopes')->insert([
    'id'            =>  'basic',
    'description'   =>  'Basic details about your account',
]);

Capsule::table('oauth_scopes')->insert([
    'id'            =>  'email',
    'description'   =>  'Your email address',
]);

Capsule::table('oauth_scopes')->insert([
    'id'            =>  'photo',
    'description'   =>  'Your photo',
]);

/******************************************************************************/

print 'Creating sessions table'.PHP_EOL;

Capsule::schema()->create('oauth_sessions', function ($table) {
    $table->increments('id')->unsigned();
    $table->string('owner_type');
    $table->string('owner_id');
    $table->string('client_id');
    $table->string('client_redirect_uri')->nullable();

    $table->foreign('client_id')->references('id')->on('oauth_clients')->onDelete('cascade');
});

Capsule::table('oauth_sessions')->insert([
    'owner_type'    =>  'client',
    'owner_id'      =>  'testclient',
    'client_id'     =>  'testclient',
]);

Capsule::table('oauth_sessions')->insert([
    'owner_type'    =>  'user',
    'owner_id'      =>  '1',
    'client_id'     =>  'testclient',
]);

Capsule::table('oauth_sessions')->insert([
    'owner_type'    =>  'user',
    'owner_id'      =>  '2',
    'client_id'     =>  'testclient',
]);

/******************************************************************************/

print 'Creating access tokens table'.PHP_EOL;

Capsule::schema()->create('oauth_access_tokens', function ($table) {
    $table->string('access_token')->primary();
    $table->integer('session_id')->unsigned();
    $table->integer('expire_time');

    $table->foreign('session_id')->references('id')->on('oauth_sessions')->onDelete('cascade');
});

Capsule::table('oauth_access_tokens')->insert([
    'access_token'  =>  'iamgod',
    'session_id'    =>  '1',
    'expire_time'   =>  time() + 86400,
]);

/******************************************************************************/

print 'Creating refresh tokens table'.PHP_EOL;

Capsule::schema()->create('oauth_refresh_tokens', function ($table) {
    $table->string('refresh_token')->primary();
    $table->integer('expire_time');
    $table->string('access_token');

    $table->foreign('access_token')->references('access_token')->on('oauth_access_tokens')->onDelete('cascade');
});

/******************************************************************************/

print 'Creating auth codes table'.PHP_EOL;

Capsule::schema()->create('oauth_auth_codes', function ($table) {
    $table->string('auth_code')->primary();
    $table->integer('session_id')->unsigned();
    $table->integer('expire_time');
    $table->string('client_redirect_uri');

    $table->foreign('session_id')->references('id')->on('oauth_sessions')->onDelete('cascade');
});

/******************************************************************************/

print 'Creating oauth access token scopes table'.PHP_EOL;

Capsule::schema()->create('oauth_access_token_scopes', function ($table) {
    $table->increments('id')->unsigned();
    $table->string('access_token');
    $table->string('scope');

    $table->foreign('access_token')->references('access_token')->on('oauth_access_tokens')->onDelete('cascade');
    $table->foreign('scope')->references('id')->on('oauth_scopes')->onDelete('cascade');
});

Capsule::table('oauth_access_token_scopes')->insert([
    'access_token'  =>  'iamgod',
    'scope'         =>  'basic',
]);

Capsule::table('oauth_access_token_scopes')->insert([
    'access_token'  =>  'iamgod',
    'scope'         =>  'email',
]);

Capsule::table('oauth_access_token_scopes')->insert([
    'access_token'  =>  'iamgod',
    'scope'         =>  'photo',
]);

/******************************************************************************/

print 'Creating oauth auth code scopes table'.PHP_EOL;

Capsule::schema()->create('oauth_auth_code_scopes', function ($table) {
    $table->increments('id');
    $table->string('auth_code');
    $table->string('scope');

    $table->foreign('auth_code')->references('auth_code')->on('oauth_auth_codes')->onDelete('cascade');
    $table->foreign('scope')->references('id')->on('oauth_scopes')->onDelete('cascade');
});

/******************************************************************************/

print 'Creating oauth session scopes table'.PHP_EOL;

Capsule::schema()->create('oauth_session_scopes', function ($table) {
    $table->increments('id')->unsigned();
    $table->integer('session_id')->unsigned();
    $table->string('scope');

    $table->foreign('session_id')->references('id')->on('oauth_sessions')->onDelete('cascade');
    $table->foreign('scope')->references('id')->on('oauth_scopes')->onDelete('cascade');
});
