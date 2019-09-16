<?php
namespace App\Controllers\COURIER_OP_MOB_API;

use App\Controllers\BaseController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use App\Models\ProductMovementHistory;
use App\Models\Manifest;

class API_HistoryController extends BaseController{

	 //all
    public function all_for_product_id($req,$res,$args){
        $ProductMovementHistory = ProductMovementHistory::where('manifest_id',$args['manifest_id'])
        ->orderBy('created_at','desc')
        ->take($this->getLimitSize('L'))
        ->get();
        $data = [
            "msg_data" => $ProductMovementHistory,
            "msg_status" => "OK"
        ];
        return $res->withJSON($data,200);
    }

     //
    public function get_history_for_manifest($req,$res,$args){
    	$ProductMovementHistory = ProductMovementHistory::with(['current_warehouse'])
                ->where('track_no',$args['manifest_track_no'])
        		->orderBy('created_at', 'DESC')
        		->take($this->getLimitSize('L'))
        		->get();
        $Manifest = Manifest::where('manifest_track_no',$args['manifest_track_no'])->first();
    	$data = [
			"msg_data" => ["manifest"=>$Manifest,"history"=>$ProductMovementHistory],
			"msg_status" => "OK"
		];
		return $res->withJSON($data,200);
    }


}

?>