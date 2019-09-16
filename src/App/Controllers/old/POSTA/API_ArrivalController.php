<?php
namespace App\Controllers\POSTA;

use App\Controllers\BaseController;
use App\Controllers\POSTA\HelperController as HelperController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use App\Models\IODeparture;
use App\Models\IOArrival;

class API_ArrivalController extends BaseController{


	//custom search details
	public function search_arrivals_from_dates_center_and_department($req,$res,$args){
		$io_mode = $this->helperController->get_io_with_connector_for_arrival_departure_from_io_mode($args['io_mode']);

		if($args['status'] == "ALL"){
			$IOArrival = IOArrival::where('date_exp_arrival','>=',$args['start_dt'])
		 				->where('date_exp_arrival','<=',$args['end_dt'])
		 				->where('io_mode','=',$args['io_mode'])
		 				->where('id_center_to','=',$args['c_id'])
		 				->where('rec_department_id','=',$args['d_id'])
		 				->with($io_mode)//dynamically connect to a given table
		 				->orderby('date_exp_arrival','DESC')
		 				->get();
        	return $res->withJSON($IOArrival,200);
		}else{
			$IOArrival = IOArrival::where('date_exp_arrival','>=',$args['start_dt'])
		 				->where('date_exp_arrival','<=',$args['end_dt'])
		 				->where('io_mode','=',$args['io_mode'])
		 				->where('id_center_to','=',$args['c_id'])
		 				->where('rec_department_id','=',$args['d_id'])
		 				->where('current_status','=',$args['status'])
		 				->with($io_mode)//dynamically connect to a given table
		 				->orderby('date_exp_arrival','DESC')
		 				->get();
        	return $res->withJSON($IOArrival,200);
		}
		
	}


	//update
	public function change_status($req,$res,$args){
		$updates = $req->getParsedBody();
		$stats = [ 
			"completed" => $updates['completed'],
			"current_status"=> $updates['current_status'],
			"remarks"=> $updates['remarks']
		];
		$update_status = IOArrival::where('id',$args['id'])
						->update($stats);
		$results = IOArrival::where('id',$args['id'])->first();
		$data = [
			"msg_data" => $results,
			"msg_status" => $update_status == 1 ? "FAIL TO UPDATE" :"OK"
		];
		return $res->withJSON([],200);
	}



	/*
		Delete the io arrival with the respected io arrivals for it
	*/
	public function delete($req,$res,$args){
		$IOArrival = IOArrival::where('id','=',$args['id'])->first();
		if(sizeof($IOArrival) == 0){
			$data = [ "msg_data" => "ALREADY DELETED","msg_status" => "FAILED"];
			return $res->withJSON($data,401);
		}
		$IOArrival->delete();


		$data = ["msg_data" => "DATA DELETED","msg_status" => "OK"];
		return $res->withJSON($data,200);
	}



	/*
		update the info in io arrival with the respected io arrivals
		- date and time
	*/
	public function update_sch_period($req,$res,$args){
		$updates = $req->getParsedBody();

		$inputs = [
			"date_exp_arrival" => $updates['date_exp_arrival'],
			"time_exp_arrival" => $updates['time_exp_arrival']
		];
		$update_status = IOArrival::where('id',$args['id'])
						->update($inputs);
		$results = IOArrival::where('id',$args['id'])->first();


		return $res->withJSON($results,200);
	}




	






































































	/*
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
				//save to arrival table
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

	*/


}