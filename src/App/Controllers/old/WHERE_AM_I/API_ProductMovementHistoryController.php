<?php
namespace App\Controllers\WHERE_AM_I;

use App\Controllers\BaseController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use App\Models\ProductMovementHistory;

class API_ProductMovementHistoryController extends BaseController{

	//search
	public function search($req,$res,$args){
		$ProductMovementHistory = ProductMovementHistory::where("track_no",$args['track_id'])->get();
		return $res->withJSON($ProductMovementHistory,200);
	}



}