<?php
namespace App\Controllers\GARAGE_FUEL_STOCK;

use App\Controllers\BaseController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use App\Models\GFS_IssueNote;

class API_GFS_issue_notesController extends BaseController{


	//tbl fields
	public function tbl_fields($req,$res,$args){
        $TBL = new GFS_IssueNote;
        return $res->withJSON($TBL->tbl_fields(),200);
    }

    
    //all
    public function all($req,$res,$args){
        $GFS_IssueNote = GFS_IssueNote::all();
        $data = [
            "msg_data" => $GFS_IssueNote,
            "msg_status" => "OK"
        ];
        return $res->withJSON($data,200);
        //return $res->withJSON($GFS_IssueNote,200);
    }

    //find from given id
    public function find($req,$res,$args){
        $GFS_IssueNote = GFS_IssueNote::where("id","=",$args['id'])->first();
        $data = [
            "msg_data" => $GFS_IssueNote,
            "msg_status" => "OK"
        ];
        return $res->withJSON($data,200);
		//return $res->withJSON($GFS_IssueNote,200);
    }

     //get delete
	public function delete($req,$res,$args){
		$GFS_IssueNote = GFS_IssueNote::where('id','=',$args['id'])->first();
		if(sizeof($GFS_IssueNote) == 0){
			$data = [ "msg_data" => "ALREADY DELETED","msg_status" => "FAILED"];
			return $res->withJSON($data,401);
		}
		$GFS_IssueNote->delete();
		$data = ["msg_data" => "DATA DELETED","msg_status" => "OK"];
		return $res->withJSON($data,200);
	}

	//insert
	public function insert($req,$res,$args){
		$GFS_IssueNote = GFS_IssueNote::create($req->getParsedBody());
		$data = [
			"msg_data" => GFS_IssueNote::all()->last(),
			"msg_status" => $GFS_IssueNote == null ? "FAIL TO INSERT" :"OK"
		];
		//return $res->withJSON($data,200);
		return $res->withJSON(GFS_IssueNote::all()->last(),200);
	}

	//update
	public function update($req,$res,$args){
		$updates = $req->getParsedBody();
		$update_status = GFS_IssueNote::where('id',$args['id'])
						->update($updates);
		$results = GFS_IssueNote::where('id',$args['id'])->first();
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
		$GFS_IssueNote = GFS_IssueNote::whereRaw("id LIKE '%".$key."%'")->get();
		$data = [
			"msg_data" => $GFS_IssueNote,
			"msg_status" => sizeof($GFS_IssueNote) == 0 ? "NO RESULTS FOUND" :"OK"
		];
		//return $res->withJSON($data,200);
		return $res->withJSON($GFS_IssueNote,200);
	}

}