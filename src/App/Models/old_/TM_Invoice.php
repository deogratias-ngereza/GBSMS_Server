<?php
namespace App\Models;

use \Illuminate\Database\Eloquent\Model as El_Model;


class TM_Invoice extends El_Model{
	protected $table = "tm_invoices";
    protected $connection = 'default';
    public $timestamps = false;
    protected $fillable = [ 
        "invoice_no","due_date","invoiced_amt","customer_id","payment_type","payment_status","paid_amt","payment_ref","cheque_no","description","paid_date","created_date",
    ];

   	/*return db-fields structure*/
    public function tbl_fields(){
    	return $this->fillable;
    }

}



?>