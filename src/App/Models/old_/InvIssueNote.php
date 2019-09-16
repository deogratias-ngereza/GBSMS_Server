<?php
namespace App\Models;

use \Illuminate\Database\Eloquent\Model as El_Model;


class InvIssueNote extends El_Model{
	protected $table = "inv_issue_notes";
    protected $connection = 'default';
    public $timestamps = false;
    protected $fillable = [ 
        "vehicle_id","worker_id","group_name","ref","issue_note_no","qty_issue","status","auth_worker_id","sign_on_issue_img","issued_date","created_date"
    ];

    /*return db-fields structure*/
    public function tbl_fields(){
    	return $this->fillable;
    }

}



?>