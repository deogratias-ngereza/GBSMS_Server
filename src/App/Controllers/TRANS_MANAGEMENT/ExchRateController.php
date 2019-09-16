<?php
namespace App\Controllers\TRANS_MANAGEMENT;

use App\Controllers\BaseController;
use App\Controllers\TRANS_MANAGEMENT\SystemHistoryController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use App\Models\TmExchangeRate;

class ExchRateController extends BaseController{

	protected $recorder;
	public function __construct(){
		$this->recorder = new SystemHistoryController();
	}


    
    //go to exch server and find the actual exhcange rate value..
    public function get_real_rate($req,$res,$args){

    	$from = strtoupper($args['from']);
    	$to = strtoupper($args['to']);

    	$url = "http://free.currencyconverterapi.com/api/v5/convert?q=".$from."_".$to."&compact=y";

		$ch = curl_init( $url );
		curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt( $ch, CURLOPT_HEADER, 0);
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);
		$response = curl_exec( $ch );

		$rate_value_obj = (json_decode($response,true));
		$rate_value = null;
		if ($rate_value_obj != null ) $rate_value = $rate_value_obj[$from.'_'.$to]['val'];
		
        $data = [
            "msg_data" => $rate_value,
            "msg_status" => "OK"
        ];
        return $res->withJSON($data,200);
    }

    

}