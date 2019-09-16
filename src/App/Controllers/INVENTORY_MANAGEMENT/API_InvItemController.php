<?php
namespace App\Controllers\INVENTORY_MANAGEMENT;

use App\Controllers\BaseController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use App\Models\InvItem;

class API_InvItemController extends BaseController{


	//tbl fields
	public function tbl_fields($req,$res,$args){
        $TBL = new InvItem;
        return $res->withJSON($TBL->tbl_fields(),200);
    }



    //all
    public function all($req,$res,$args){
        $InvItem = InvItem::take(100)->get();
        $data = [
            "msg_data" => $InvItem,
            "msg_status" => "OK"
        ];
        return $res->withJSON($data,200);
        //return $res->withJSON($InvItem,200);
    }

    //find from given id
    public function find($req,$res,$args){
        $InvItem = InvItem::where("id","=",$args['id'])->first();
        $data = [
            "msg_data" => $InvItem,
            "msg_status" => "OK"
        ];
        return $res->withJSON($data,200);
		//return $res->withJSON($InvItem,200);
    }
    public function search_item($req,$res,$args){
    	$qry = $req->getParsedBody()['search_key'];
        $InvItem = InvItem::whereRaw("name LIKE '%".$qry."%' OR description LIKE '%".$qry."%' OR code LIKE '%".$qry."%'")->take(10)->get();
        $data = [
            "msg_data" => $InvItem,
            "msg_status" => "OK"
        ];
        return $res->withJSON($data,200);
		//return $res->withJSON($InvItem,200);
    }

     //get delete
	public function delete($req,$res,$args){
		$InvItem = InvItem::where('id','=',$args['id'])->first();
		if(sizeof($InvItem) == 0){
			$data = [ "msg_data" => "ALREADY DELETED","msg_status" => "FAILED"];
			return $res->withJSON($data,401);
		}
		$InvItem->delete();
		$data = ["msg_data" => "DATA DELETED","msg_status" => "OK"];
		return $res->withJSON($data,200);
	}

	//insert
	public function insert($req,$res,$args){
		$InvItem = InvItem::create($req->getParsedBody());
		$data = [
			"msg_data" => InvItem::all()->last(),
			"msg_status" => $InvItem == null ? "FAIL TO INSERT" :"OK"
		];
		//return $res->withJSON($data,200);
		return $res->withJSON(InvItem::all()->last(),200);
	}

	//update
	public function update($req,$res,$args){
		$updates = $req->getParsedBody();
		$update_status = InvItem::where('id',$args['id'])
						->update($updates);
		$results = InvItem::where('id',$args['id'])->first();
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
		$InvItem = InvItem::whereRaw("id LIKE '%".$key."%'")->get();
		$data = [
			"msg_data" => $InvItem,
			"msg_status" => sizeof($InvItem) == 0 ? "NO RESULTS FOUND" :"OK"
		];
		//return $res->withJSON($data,200);
		return $res->withJSON($InvItem,200);
	}

}