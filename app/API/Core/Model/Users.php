<?php


namespace API\Core\Model;


use Illuminate\Database\Eloquent\Model;

class Users extends Model {
    public $timestamps = false;

    private $name;
    private $email;
    private $password;
    private $username;
    private $photo;


    public function messages()
    {
        return $this->hasMany('API\Core\Dao\Messages', 'to_id');
    }

}