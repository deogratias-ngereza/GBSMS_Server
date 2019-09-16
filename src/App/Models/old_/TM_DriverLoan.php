<?php
namespace App\Models;

use \Illuminate\Database\Eloquent\Model as El_Model;


class TM_DriverLoan extends El_Model{
	protected $table = "tm_driver_loans";
    protected $connection = 'default';
    public $timestamps = false;
    protected $fillable = [ 
        "driver_id","requested_loan_amt","requested_date","given","given_loan_amt","given_date","given_by_cashier_id","approved","approved_by_worker_id","status","returned_amt","exp_return_date","last_returned_date","description","created_date",
    ];
    	/*return db-fields structure*/
    public function tbl_fields(){
    	return $this->fillable;
    }

}



?>