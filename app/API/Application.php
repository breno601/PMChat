<?php
namespace API;

use API\Core\Dao\Users;
use Slim\Slim;

class Application extends Slim
{

    public function validateMessage($message = array(), $action = 'create'){ // there is this action for future implementations to allow update of messages

        $errors = array();
        $message = filter_var_array(
            $message,
            array(
                'from_id' => FILTER_SANITIZE_NUMBER_INT,
                'username' => FILTER_SANITIZE_STRING,
                'title' => FILTER_SANITIZE_STRING,
                'message' => FILTER_SANITIZE_STRING,
            ),
            false
        );

        if (empty($message['from_id'])) {
            $errors['message'][] = array(
                'field' => 'from_id',
                'message' => 'Message from field cannot be empty'
            );
        }

        if (empty($message['username'])) {
            $errors['message'][] = array(
                'field' => 'username',
                'message' => 'Username field cannot be empty'
            );
        }else{
            $user = Users::where('username', '=', $message['username'])->first();
            if(is_null($user)){  // user does not exist
                $errors['message'][] = array(
                    'field' => 'username',
                    'message' => 'Username does not exists!'
                );
            }
        }

        if (empty($message['title'])) {
            $errors['user'][] = array(
                'field' => 'title',
                'message' => 'Title field cannot be empty'
            );
        }

        return $errors;

   }

    public function validateUser($user = array(), $action = 'create')  // there is this action for future implementations to allow update of users fields
    {
        $errors = array();

        $user = filter_var_array(
            $user,
            array(
                'name' => FILTER_SANITIZE_STRING,
                'username' => FILTER_SANITIZE_STRING,
                'email' => FILTER_SANITIZE_EMAIL,
                'password' => FILTER_SANITIZE_STRING,
            ),
            false
        );

        if (empty($user['email'])) {
            $errors['user'][] = array(
                'field' => 'email',
                'message' => 'Email address cannot be empty'
            );
        } elseif (false === filter_var(
                $user['email'],
                FILTER_VALIDATE_EMAIL
            )) {
            $errors['user'][] = array(
                'field' => 'email',
                'message' => 'Email address is invalid'
            );
        } else {

            // Test for unique email
            $results = $userNameExists = Users::where('email', '=', $user['email'])->get();

            if(count($results) > 0) {
                $errors['user'][] = array(
                    'field' => 'email',
                    'message' => 'Email address already exists'
                );
            }

        }
        if (empty($user['username'])) {

            $errors['user'][] = array(
                'field' => 'username',
                'message' => 'Username field cannot be empty'
            );

        }else if (isset($user['username'])){
            $userNameExists = Users::where('username', '=', $user['username'])->get();

            if(count($userNameExists) > 0) {
                $errors['user'][] = array(
                    'field' => 'username',
                    'message' => 'Username already exists'
                );
            }

        }


        return $errors;
    }

}
