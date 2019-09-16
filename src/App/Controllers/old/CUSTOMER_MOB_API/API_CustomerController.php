<?php
namespace App\Controllers\CUSTOMER_MOB_API;

use App\Controllers\BaseController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use App\Models\Customer;

class API_CustomerController extends BaseController{

	//update
	public function update($req,$res,$args){
		$updates = $req->getParsedBody();
		$update_status = Customer::where('id',$args['id'])
						->update($updates);
		$results = Customer::where('id',$args['id'])->first();
		$data = [
			"msg_data" => $results,
			"msg_status" => $update_status == 1 ? "FAIL TO UPDATE" :"OK"
		];
		//return $res->withJSON($data,200);
		return $res->withJSON($results,200);
	}

}

?>