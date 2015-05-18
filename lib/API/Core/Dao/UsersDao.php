<?php

namespace API\Core\Dao;

use \Illuminate\Database\Eloquent\Model as Eloquent;

abstract class UsersDao extends Eloquent {

    public abstract function insert();
    public abstract function getId($username);
    public abstract function getAllUsers();

}