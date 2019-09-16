<?php
namespace App\Models;

use \Illuminate\Database\Eloquent\Model as El_Model;


class Io extends El_Model{
	protected $table = "io";
    protected $connection = 'default';
    public $timestamps = false;
    protected $fillable = [ 
       "domestic_international_cat","completed","current_status","rec_department_id","rec_department_name","code_center_from","code_center_to","auth_by_from","auth_by_to","item_name","item_in_bulk","item_details","item_code","item_user_id","item_counts","io_mode","io_transport_id","date_created","date_updated","date_exp_arrival","date_arrived","date_exp_departure","date_departure","time_exp_arrival","time_arrived","time_exp_departure","time_departure","remarks",
    ];

}



?>