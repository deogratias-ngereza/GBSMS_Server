<?php
namespace App\Models;

use \Illuminate\Database\Eloquent\Model as El_Model;


class CashRequest extends El_Model{
	protected $table = "cash_requests";
    protected $connection = 'default';
    public $timestamps = false;
    protected $fillable = [ 
        "id","purpose","purpose_description","customer_id","for_worker_id","amt","approved","approved_by","approved_date","manifest_track_no","created_by","created_at","given","given_by","given_date"
    ];

    public function customer(){
        return $this->belongsTo('App\Models\Customer','customer_id');
    }

    public function worker(){
        return $this->belongsTo('App\Models\Worker','for_worker_id');
    }

    public function creator(){
        return $this->belongsTo('App\Models\Worker','created_by');
    }

    public function approver(){
        return $this->belongsTo('App\Models\Worker','approved_by');
    }


}



?>