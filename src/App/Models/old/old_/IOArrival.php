<?php
namespace App\Models;

use \Illuminate\Database\Eloquent\Model as El_Model;


class IOArrival extends El_Model{
	protected $table = "io_arrivals";
    protected $connection = 'default';
    public $timestamps = false;
    protected $fillable = [ 
        "domestic_international_cat","completed","current_status","rec_department_id","rec_department_name","code_center_from","from","io_departure_ref","code_center_to","id_center_from","id_center_to","auth_by","item_name","item_in_bulk","item_details","item_code","item_user_id","item_counts","io_mode","io_transport_id","date_created","date_updated","date_exp_arrival","date_arrived","time_exp_arrival","time_arrived","remarks"
    ];

    //has one bus
    public function bus()
    {
        return $this->hasOne('App\Models\BusCarrier','id','io_transport_id');
    }
    //has one ship
    public function ship()
    {
        return $this->hasOne('App\Models\ShipCarrier','id','io_transport_id');
    }
    //has one train
    public function train()
    {
        return $this->hasOne('App\Models\TrainCarrier','id','io_transport_id');
    }
    //has one flight
    public function flight()
    {
        return $this->hasOne('App\Models\FlightCarrier','id','io_transport_id');
    }

}



?>