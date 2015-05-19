<?php

namespace API\Core\Controller;


use API\Application;

class Users extends Core {
    public $usersModel;
    public $sanitizor;

    public function __construct() {
        parent::__construct();
        $this->usersModel = new \API\Core\Model\Users();
        $this->usersDao = new \API\Core\Dao\Users();
        $this->sanitizor = new \API\Application();
    }

    public function select() {
        $users = $this->usersDao->getInstance()->getAllUsers();
        echo json_encode($users, JSON_PRETTY_PRINT);
    }

    public function insert() {
        $body = $this->app->request->getBody();
        $errors = $this->sanitizor->validateUser($body);
        if(empty($errors)){
            $this->usersModel->username = $body["username"];
            $this->usersModel->name = $body["name"];
            $this->usersModel->email = $body["email"];
            $this->usersModel->password = password_hash($body["password"], PASSWORD_DEFAULT);
            $this->usersModel->photo = $body["photo"];
            if($this->usersDao->getInstance()->insert($this->usersModel)){
                echo json_encode("Success", JSON_PRETTY_PRINT);
            }else{
                echo json_encode("Fail", JSON_PRETTY_PRINT);
            }

        }else {
            echo json_encode("Fail", JSON_PRETTY_PRINT);
        }
/*


  */

    }

    public function getId($id) {
        $id = $this->usersDao->getInstance()->getId($id);
        echo json_encode($id, JSON_PRETTY_PRINT);
    }
}