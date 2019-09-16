<?php
namespace App\Models;

use \Illuminate\Database\Eloquent\Model as El_Model;


class Centers_has_train_carriers extends El_Model{
	protected $table = "centers_has_train_carriers";
    protected $connection = 'default';
    public $timestamps = false;
    protected $fillable = [ 
        "center_id","train_carrier_id","name","route_arrival","route_departure","time_arrival","time_departure","working_days",
    ];
     //has one train
    public function train()
    {
        return $this->hasOne('App\Models\TrainCarrier','id','train_carrier_id');
    }

}



?>