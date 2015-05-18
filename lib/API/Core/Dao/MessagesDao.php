<?php

namespace API\Core\Dao;

use \Illuminate\Database\Eloquent\Model as Eloquent;

abstract class MessagesDao extends Eloquent {

    public abstract function insert($object = "", $username);
    public abstract function getNames($id);
    public abstract function getAllMessages();
    public abstract function getAllMessagesFromId($id, $nid);


}