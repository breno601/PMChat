<?php

namespace API\Core\Model;


use Illuminate\Database\Eloquent\Model;

class Messages extends Model{
    public $timestamps = true;

    private $to_id;
    private $from_id;
    private $message;
    private $title;

    public function users()
    {
        return $this->belongsTo('API\Core\Dao\Users', 'to_id');
    }

}