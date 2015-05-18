<?php

namespace API\Core\Dao;

use API\Application;
use \Illuminate\Database\Capsule\Manager as Capsule;

class Users extends UsersDao {
    public $timestamps = false;

    private $user;
    protected $table = "users";
    protected $primaryKey = "id";

    private static $instance;

    function __construct() {
        parent::__construct();
        $this->user = new \API\Core\Model\Users();
    }


    public static function getInstance() {
        if (!isset(self::$instance)) {
            $class = __CLASS__;
            self::$instance = new $class;
        }

        return self::$instance;
    }


    public function insert($object = "" )
    {
        $this->user = $object;

        $userNameExists = Users::where('username', '=', $this->user->username)->get();

        if(count($userNameExists) == 1) {
            return false;   // SHOULD FAIL BECAUSE IT IS A DUPLICATED Username
        }

        if($this->user->save()){
            return true;
        }
        return false;

    }

    public function getId($username)
    {
        $query = Capsule::table($this->table)
            ->select(['id'])->where('username','=', $username);
        $result = $query->get();
        return $result;

    }

    public function getAllUsers()
    {
        return $users = $this->user->all();
    }
}