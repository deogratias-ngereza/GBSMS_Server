<?php
namespace App\Models;

use \Illuminate\Database\Eloquent\Model as El_Model;


class Admin extends El_Model{
	protected $table = "admins";
    protected $connection = 'default';
    public $timestamps = false;
    protected $fillable = [ 
       "username","first_name","last_name","email","password","address","phone","depart_id","depart_name","role","reg_at","updated_at","center_code",
    ];

}



?>