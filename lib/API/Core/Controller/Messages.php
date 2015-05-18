<?php

namespace API\Core\Controller;


use API\Application;

class Messages extends Core {
    public $messagesModel;
    public $messagesDao;
    public $sanitizor;

    public function __construct() {
        parent::__construct();
        $this->messagesModel = new \API\Core\Model\Messages();
        $this->messagesDao = new \API\Core\Dao\Messages();
        $this->sanitizor = new \API\Application();
    }

    public function select() {

        $messages = $this->messagesDao->getInstance()->getAllMessages();
        echo json_encode($messages, JSON_PRETTY_PRINT);

    }


    public function getNames($id){

        $output = $this->messagesDao->getInstance()->getNames($id);
        echo json_encode($output, JSON_PRETTY_PRINT);
    }

    public function insert() {
        $body = $this->app->request->getBody();   // REVISAR ISSO DO POST SEM FALTA
        $errors = $this->sanitizor->validateMessage($body);
        if(empty($errors)) {
            $username = $body["username"];

            $this->messagesModel->title = $body["title"];
            $this->messagesModel->message = $body["message"];
            $this->messagesModel->from_id = $body["from_id"];

            if ($this->messagesDao->getInstance()->insert($this->messagesModel, $username)) {
                echo json_encode("Success.", JSON_PRETTY_PRINT);
            } else {
                echo json_encode("Fail. User probably does not exist.", JSON_PRETTY_PRINT);
            }
        }else{
            echo json_encode("Fail. Perhaps you are missing a field?", JSON_PRETTY_PRINT);
        }


    }

    public function getMessageListFromUser($id, $tid) {

        $output = $this->messagesDao->getInstance()->getAllMessagesFromId($id, $tid);
        echo json_encode($output, JSON_PRETTY_PRINT);


    }


}

