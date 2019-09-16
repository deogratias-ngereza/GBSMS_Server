<?php
namespace App\Models;

use \Illuminate\Database\Eloquent\Model as El_Model;


class InvBrokenAndLostRepo extends El_Model{
	protected $table = "inv_broken_n_lost_reports";
    protected $connection = 'default';
    public $timestamps = false;
    protected $fillable = [ 
       "for","item_id","qty","description","reported_date","reporter_id","resolved","resolved_date","resolved_by_worker_id","status","amt","currency"
    ];

    /*return db-fields structure*/
    public function tbl_fields(){
    	return $this->fillable;
    }





}



?>