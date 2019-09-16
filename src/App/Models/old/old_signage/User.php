<?php
namespace App\Models;

use \Illuminate\Database\Eloquent\Model as El_Model;


class User extends El_Model{
	protected $table = "users";
    protected $connection = 'default';
    public $timestamps = false;
    protected $fillable = [ 
        "company_id","email","first_name","last_name","password","role","created_at",
    ];

}



?>