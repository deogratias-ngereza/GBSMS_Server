<?php
namespace App\Controllers\COURIER_API;

use App\Controllers\BaseController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use App\Models\ZonalTarrif;

class API_ZonalTarrifController extends BaseController{



	 //get tarrif for a customer from package,destination_zone and given weight value
    public function get_tarrif_for_cust($req,$res,$args){
    	///{package}/{zone}/{weight}
    	$weight = trim($req->getQueryParams()['weight'],"'");
    	$zone = trim($req->getQueryParams()['zone'],"'");
    	$package = trim($req->getQueryParams()['package'],"'");

        $ZonalTarrif = ZonalTarrif::where("package_name",$package)
        				->where("destination_zone",$zone)
        				->where("weight_in_kg",$weight)
        				->first();
        $data = [
            "msg_data" => $ZonalTarrif,
            "msg_status" => "OK"
        ];
        //return $res->withJSON($data,200);
        return $res->withJSON($ZonalTarrif,200);
    }

    //all
    public function all($req,$res,$args){
        $ZonalTarrif = ZonalTarrif::all();
        $data = [
            "msg_data" => $ZonalTarrif,
            "msg_status" => "OK"
        ];
        //return $res->withJSON($data,200);
        return $res->withJSON($ZonalTarrif,200);
    }

    //find from given id
    public function find($req,$res,$args){
        $ZonalTarrif = ZonalTarrif::where("id","=",$args['id'])->first();
        $data = [
            "msg_data" => $ZonalTarrif,
            "msg_status" => "OK"
        ];
        //return $res->withJSON($data,200);
		return $res->withJSON($ZonalTarrif,200);
    }

    //for package and for zone
    public function zonal_tarrifs_for_pckg_zone($req,$res,$args){
        $ZonalTarrif = ZonalTarrif::where("package_name","=",$args['package'])
        			->where("destination_zone","=",$args['zone'])
        			->get();
        $data = [
            "msg_data" => $ZonalTarrif,
            "msg_status" => "OK"
        ];
        //return $res->withJSON($data,200);
		return $res->withJSON($ZonalTarrif,200);
    }


//



     //get delete
	public function delete($req,$res,$args){
		$ZonalTarrif = ZonalTarrif::where('id','=',$args['id'])->first();
		if(sizeof($ZonalTarrif) == 0){
			$data = [ "msg_data" => "ALREADY DELETED","msg_status" => "FAILED"];
			return $res->withJSON($data,401);
		}
		$ZonalTarrif->delete();
		$data = ["msg_data" => "DATA DELETED","msg_status" => "OK"];
		return $res->withJSON($data,200);
	}

	//insert
	public function insert($req,$res,$args){
		$ZonalTarrif = ZonalTarrif::create($req->getParsedBody());
		$data = [
			"msg_data" => ZonalTarrif::all()->last(),
			"msg_status" => $ZonalTarrif == null ? "FAIL TO INSERT" :"OK"
		];
		//return $res->withJSON($data,200);
		return $res->withJSON(ZonalTarrif::all()->last(),200);
	}

	//update
	public function update($req,$res,$args){
		$updates = $req->getParsedBody();
		$update_status = ZonalTarrif::where('id',$args['id'])
						->update($updates);
		$results = ZonalTarrif::where('id',$args['id'])->first();
		$data = [
			"msg_data" => $results,
			"msg_status" => $update_status == 1 ? "FAIL TO UPDATE" :"OK"
		];
		//return $res->withJSON($data,200);
		return $res->withJSON($results,200);
	}

	//search
	public function search($req,$res,$args){
		$key = trim($req->getQueryParams()['key'],"'");
		$ZonalTarrif = ZonalTarrif::whereRaw("id LIKE '%".$key."%'")->get();
		$data = [
			"msg_data" => $ZonalTarrif,
			"msg_status" => sizeof($ZonalTarrif) == 0 ? "NO RESULTS FOUND" :"OK"
		];
		//return $res->withJSON($data,200);
		return $res->withJSON($ZonalTarrif,200);
	}

}