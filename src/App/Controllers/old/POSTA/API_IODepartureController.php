<?php
namespace App\Controllers\POSTA;

use App\Controllers\BaseController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use App\Models\IODeparture;
use App\Models\IOArrival;

class API_IODepartureController extends BaseController{

    //all
    public function all($req,$res,$args){
        $IODeparture = IODeparture::all();
        return $res->withJSON($IODeparture,200);
    }

    //find from given id
    public function find($req,$res,$args){
        $IODeparture = IODeparture::where("id","=",$args['id'])->first();
		return $res->withJSON($IODeparture,200);
    }

     //get delete
	public function delete($req,$res,$args){
		$IODeparture = IODeparture::where('id','=',$args['id'])->first();
		if(sizeof($IODeparture) == 0){
			$data = [ "msg_data" => "ALREADY DELETED","msg_status" => "FAILED"];
			return $res->withJSON($data,401);
		}
		$IODeparture->delete();
		$data = ["msg_data" => "DATA DELETED","msg_status" => "OK"];
		return $res->withJSON($data,200);
	}

	//insert
	public function insert($req,$res,$args){
		$IODeparture = IODeparture::create($req->getParsedBody());
		return $res->withJSON($IODeparture == null ? "FAIL TO INSERT" : IODeparture::all()->last(),200);
	}




	//custom insert 
	public function custom_insert($req,$res,$args){
		$inputs = $req->getParsedBody();
		$inputs["to"] = $req->getParsedBody()['transporter']['route_departure'];//TODO
		$inputs['code_center_to'] = json_encode($req->getParsedBody()['code_center_to'],true);
		$inputs['id_center_to'] = json_encode($req->getParsedBody()['id_center_to'],true);

		$IODeparture = IODeparture::create($inputs);//save to departure table
		if($IODeparture != null){
			for ($arrival = 0; $arrival < sizeof($req->getParsedBody()['code_center_to']); $arrival++) { 
				//save to arrival table -- TODO  arrival time from given bus id 
				$inputs['io_departure_ref'] = $IODeparture->id;
				$inputs['current_status'] = "SCHEDULED";
				$inputs['code_center_to'] = $inputs['to_centers'][$arrival]['center_code'];
				$inputs['id_center_to'] = $inputs['to_centers'][$arrival]['id'];
				$inputs['date_exp_arrival'] = $inputs['date_exp_arrival'];
				IOArrival::create($inputs);
			}
			return $res->withJSON($IODeparture,200);
		}
		else{
			return $res->withJSON("FAIL TO ADD",400);
		}
	}//






	//update
	public function update($req,$res,$args){
		$updates = $req->getParsedBody();
		$update_status = IODeparture::where('id',$args['id'])
						->update($updates);
		$results = IODeparture::where('id',$args['id'])->first();
		$data = [
			"msg_data" => $results,
			"msg_status" => $update_status == 1 ? "FAIL TO UPDATE" :"OK"
		];

		return $res->withJSON($results,200);
	}

	//search
	public function search($req,$res,$args){
		$key = trim($req->getQueryParams()['key'],"'");
		$IODeparture = IODeparture::whereRaw("id LIKE '%".$key."%'")->get();
		$data = [
			"msg_data" => $IODeparture,
			"msg_status" => sizeof($IODeparture) == 0 ? "NO RESULTS FOUND" :"OK"
		];
		//return $res->withJSON($data,200);
		return $res->withJSON($IODeparture,200);
	}

}