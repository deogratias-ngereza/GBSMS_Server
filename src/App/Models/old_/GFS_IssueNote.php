<?php
namespace App\Models;

use \Illuminate\Database\Eloquent\Model as El_Model;


class GFS_IssueNote extends El_Model{
	protected $table = "gfs_issue_notes";
    protected $connection = 'default';
    public $timestamps = false;
    protected $fillable = [ 
        "vehicle_id","driver_id","driver_name","group_name","ref","issue_note_no","qty_issue","qty_given","fuel_type","status","issue_by_worker_id","close_meter_readings","open_meter_redings","filled_date_time","created_date",
    ];

    /*return db-fields structure*/
    public function tbl_fields(){
    	return $this->fillable;
    }

}



?>