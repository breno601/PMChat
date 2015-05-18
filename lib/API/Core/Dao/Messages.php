<?php

namespace API\Core\Dao;

use API\Core\Model\Users;
use \Illuminate\Database\Capsule\Manager as Capsule;  // I may use this to to build custom queries later

class Messages extends MessagesDao  {
    public $timestamps = true;

    private $message;
    protected $table = "messages";
    protected $primaryKey = "id";

    private static $instance;

    function __construct() {
        parent::__construct();
        $this->message = new \API\Core\Model\Messages();
    }

    public static function getInstance() {
        if (!isset(self::$instance)) {
            $class = __CLASS__;
            self::$instance = new $class;
        }

        return self::$instance;
    }

    public function insert($object = "", $username)
    {
        $this->message = $object;
        $user = Users::where('username', '=', $username)->first();
        if(is_null($user)){  // user does not exist
            return false;
        }
        $this->message->users()->associate($user);
        if($this->message->save()){
            return true;
        }
        return false;
    }

    public function getNames($id)
    {
        $messages = Users::find($id)->messages()->orderBy('created_at','desc')->groupBy('from_id')->get();


        $array_ = Array();
        foreach ($messages as $message)
        {
            $nid = $message->from_id;
            $user = Users::find($nid);
            array_push($array_,
                array(
                    $nid,
                    $user->name,
                    $user->photo
                )
            );
        }
        return $array_;
    }

    public function getAllMessages()
    {
        return $users = $this->message->all();
    }

    public function getAllMessagesFromId($id, $tid)   // I am logged in as the $id. I am searching for messages from $tid to me.
    {
        $output =  Users::find($tid)->messages()->where('from_id', '=', $id)->orderBy('created_at', 'desc')->get();
        return $output;
    }
}