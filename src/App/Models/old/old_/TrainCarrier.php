<?php
namespace App\Models;

use \Illuminate\Database\Eloquent\Model as El_Model;


class TrainCarrier extends El_Model{
	protected $table = "train_carriers";
    protected $connection = 'default';
    public $timestamps = false;
    protected $fillable = [ 
       "name","train_no","train_description",
    ];

}



?>