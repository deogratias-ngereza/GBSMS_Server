<?php
namespace App\Controllers\SIGNAGE_API\Worker;

use App\Controllers\BaseController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use App\Models\Company;
use App\Models\Media;
use App\Models\Channel;

class API_WorkerController extends BaseController{

	  //all
    public function company_profile($req,$res,$args){

    	$Company = Company::where("id","=",$args['id'])->first();
        $Channels = Channel::where('company_id',$args['id'])->with('medias')->get();

        $profile = ["company" => $Company,"channels" => $Channels];
        $data = [
            "msg_data" => (object) $profile,
            "msg_status" => "OK"
        ];
        return $res->withJSON($data,200);
    }

}