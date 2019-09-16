<?php
namespace App\Controllers\TRANS_MANAGEMENT;

use App\Controllers\BaseController;
use App\Controllers\TRANS_MANAGEMENT\SystemHistoryController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use App\Models\TM_CustRate_N_ProductAllowableLoss;

class API_TM_CustRate_N_Product_AllowableLosseController extends BaseController{

	protected $recorder;
	public function __construct(){
		$this->recorder = new SystemHistoryController();
	}

	//tbl fields
	public function tbl_fields($req,$res,$args){
        $TBL = new TM_CustRate_N_ProductAllowableLoss;
        return $res->withJSON($TBL->tbl_fields(),200);
    }


    
    //all
    public function all($req,$res,$args){
        $TM_CustRate_N_ProductAllowableLoss = TM_CustRate_N_ProductAllowableLoss::with(['destination','customer'])->get();
        $data = [
            "msg_data" => $TM_CustRate_N_ProductAllowableLoss,
            "msg_status" => "OK"
        ];
        return $res->withJSON($data,200);
        //return $res->withJSON($TM_CustRate_N_ProductAllowableLoss,200);
    }

    //find from given id
    public function find($req,$res,$args){
        $TM_CustRate_N_ProductAllowableLoss = TM_CustRate_N_ProductAllowableLoss::where("id","=",$args['id'])->first();
        $data = [
            "msg_data" => $TM_CustRate_N_ProductAllowableLoss,
            "msg_status" => "OK"
        ];
        return $res->withJSON($data,200);
		//return $res->withJSON($TM_CustRate_N_ProductAllowableLoss,200);
    }

     //get delete
	public function delete($req,$res,$args){
		$TM_CustRate_N_ProductAllowableLoss = TM_CustRate_N_ProductAllowableLoss::where('id','=',$args['id'])->first();
		if(sizeof($TM_CustRate_N_ProductAllowableLoss) == 0){
			$data = [ "msg_data" => "ALREADY DELETED","msg_status" => "FAILED"];
			return $res->withJSON($data,401);
		}
		$TM_CustRate_N_ProductAllowableLoss->delete();
		$data = ["msg_data" => "DATA DELETED","msg_status" => "OK"];
		$this->recorder->record_rate_n_loss_act("DELETE","Entry with id ".$args['id'].' deleted.');
		return $res->withJSON($data,200);
	}

	//insert
	public function insert($req,$res,$args){
		$TM_CustRate_N_ProductAllowableLoss = TM_CustRate_N_ProductAllowableLoss::create($req->getParsedBody());
		$data = [
			"msg_data" => TM_CustRate_N_ProductAllowableLoss::all()->last(),
			"msg_status" => $TM_CustRate_N_ProductAllowableLoss == null ? "FAIL TO INSERT" :"OK"
		];
		$this->recorder->record_rate_n_loss_act("NEW","Entry with customer id ".$req->getParsedBody()['customer_id'].' created.');
		return $res->withJSON(TM_CustRate_N_ProductAllowableLoss::all()->last(),200);
	}

	//update
	public function update($req,$res,$args){
		$updates = $req->getParsedBody();
		$update_status = TM_CustRate_N_ProductAllowableLoss::where('id',$args['id'])
						->update($updates);
		$results = TM_CustRate_N_ProductAllowableLoss::where('id',$args['id'])->first();
		$data = [
			"msg_data" => $results,
			"msg_status" => $update_status == 1 ? "FAIL TO UPDATE" :"OK"
		];
		$this->recorder->record_rate_n_loss_act("UPDATE","Entry with id ".$args['id'].' updated.');
		return $res->withJSON($results,200);
	}

	//search
	public function search($req,$res,$args){
		$key = trim($req->getQueryParams()['key'],"'");
		$TM_CustRate_N_ProductAllowableLoss = TM_CustRate_N_ProductAllowableLoss::whereRaw("id LIKE '%".$key."%'")->get();
		$data = [
			"msg_data" => $TM_CustRate_N_ProductAllowableLoss,
			"msg_status" => sizeof($TM_CustRate_N_ProductAllowableLoss) == 0 ? "NO RESULTS FOUND" :"OK"
		];
		//return $res->withJSON($data,200);
		return $res->withJSON($TM_CustRate_N_ProductAllowableLoss,200);
	}

}