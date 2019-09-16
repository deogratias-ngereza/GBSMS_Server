<?php
namespace App\Models;

use \Illuminate\Database\Eloquent\Model as El_Model;


class Invoice extends El_Model{
	protected $table = "invoices";
    protected $connection = 'default';
    public $timestamps = false;
    protected $fillable = [ 
        "invoice_no","req_amt","paid_amt","due_amt","cleared","payment_mode","cheque_no","paid_date","created_by","remarks","received_by","customer_id","created_at","due_date","description",
    ];


    public function customer(){
        return $this->belongsTo('App\Models\Customer','customer_id');
    }
    public function creator(){
        return $this->belongsTo('App\Models\Worker','created_by');
    }
    public function receiver(){
        return $this->belongsTo('App\Models\Worker','received_by');
    }



}



?>