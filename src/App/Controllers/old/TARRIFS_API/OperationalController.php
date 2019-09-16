<?php
namespace App\Controllers\TARRIFS_API;

use App\Controllers\BaseController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use Illuminate\Database\Capsule\Manager as DB;


use App\Controllers\TARRIFS_API\BaseTarrifController;

use App\Models\Customer;


use App\Models\ZonalTarrif;
use App\Models\TR_SD_FTL_MANTRACK_TARRIF;
use App\Models\TR_SD_LTL_MANTRACK_TARRIF;
use App\Models\TR_DEST_TOYOTA_TARIFF;
use App\Models\TR_DEST_AZURI_TARIFF;
use App\Models\TR_ZANZ_INS_TARIFF;
use App\Models\TR_DEST_BASED_TARIFF;
use App\Models\TR_FULL_FLAT;
use App\Models\TR_TIGO_DEST_BASED_TARIFF;


//
/*
major tariffs categories
-> ZONAL
-> FTL_MANTRACK
-> LTL_MANTRACK
-> DEST_BASED
-> SOURCE_DEST_BASED
*/


class OperationalController extends BaseTarrifController{

    //all
    public function all($req,$res,$args){
        $Customer = Customer::with('manager')->orderBy('id','desc')->get();
        $data = [
            "msg_data" => $Customer,
            "msg_status" => "OK"
        ];
        //return $res->withJSON($data,200);
        return $res->withJSON($Customer,200);
    }




    //all tarrifs based on the category
    public function get_all_categorized_tarrifs($req,$res,$args){
    	$i_category = trim($req->getQueryParams()['category'],"'");//$args['category'];
    	$info = $this->my_info($i_category);
    	$tarrifs = DB::connection('default')->table($info["table"])->get();
    	$data = [
            "msg_data" => $tarrifs,//json_encode($tarrifs),
            "msg_status" => "OK"
        ];
        return $res->withJSON($data,200);
    }





    //base on source warehouse/center
    public function get_tarrifs_base_on_source_warehouse($req,$res,$args){
    	$i_source = trim($req->getQueryParams()['source'],"'");
    	$i_category = trim($req->getQueryParams()['category'],"'");//$args['category'];
    	$i_package = trim($req->getQueryParams()['package'],"'");

    	$info = $this->my_info($i_category);
    	$tarrifs = DB::connection('default')->table($info["table"])
    			   ->where('source_warehouse',$i_source)
    			   ->where('package_name','=',$i_package)
    			   ->get();
    	$data = [
            "msg_data" => $tarrifs,//json_encode($tarrifs),
            "msg_status" => "OK"
        ];
        return $res->withJSON($data,200);
    }

     //base on destination warehouse/center
    public function get_tarrifs_base_on_destination_warehouse($req,$res,$args){
    	$i_source = trim($req->getQueryParams()['destination'],"'");
    	$i_category = trim($req->getQueryParams()['category'],"'");//$args['category'];
    	$i_package = trim($req->getQueryParams()['package'],"'");

    	$info = $this->my_info($i_category);
    	$tarrifs = DB::connection('default')->table($info["table"])
    			   ->where('destination_warehouse',$i_source)
    			   ->where('package_name','=',$i_package)
    			   ->get();
    	$data = [
            "msg_data" => $tarrifs,//json_encode($tarrifs),
            "msg_status" => "OK"
        ];
        return $res->withJSON($data,200);
    }
    //base on cat and package
    public function get_tarrifs_base_on_category_and_package($req,$res,$args){
    	$i_category = trim($req->getQueryParams()['category'],"'");//$args['category'];
    	$i_package = trim($req->getQueryParams()['package'],"'");

    	$info = $this->my_info($i_category);
    	$tarrifs = DB::connection('default')->table($info["table"])
    			   ->where('category',$i_category)
    			   ->where('package_name','=',$i_package)
    			   ->get();
    	$data = [
            "msg_data" => $tarrifs,//json_encode($tarrifs),
            "msg_status" => "OK"
        ];
        return $res->withJSON($data,200);
    }











    //push tarrif to the server 
    public function push_tarrif($req,$res,$args){

    	//return "POST DATA";

    	$this->push_new_tarrif($args['category'],$req->getParsedBody());
    	$data = [
            "msg_data" => "UPLOADED",//json_encode($tarrifs),
            "msg_status" => "OK"
        ];
        return $res->withJSON($data,200);
    }

    //update tarrif
    public function update_tarrif($req,$res,$args){
    	$this->update_tarrif_by_category($args['category'],$args['id'],$req->getParsedBody());
    	$data = [
            "msg_data" => "UPDATED",//json_encode($tarrifs),
            "msg_status" => "OK"
        ];
        return $res->withJSON($data,200);
    }

    //delete a tariff
    public function delete_tarrif($req,$res,$args){
    	$this->delete_tarrif_by_category($args['category'],$args['id']);
    	$data = [
            "msg_data" => "DELETED",//json_encode($tarrifs),
            "msg_status" => "OK"
        ];
        return $res->withJSON($data,200);
    }







    /*
		search base on 
		- category
		- package
		- source_code
		- destination_code
		- weight
    */
    public function get_tarrif_for($req,$res,$args){

    	$i_source = trim($req->getQueryParams()['source'],"'");
    	$i_destination = trim($req->getQueryParams()['destination'],"'");
    	$i_weight = trim($req->getQueryParams()['weight'],"'");
    	$i_category = trim($req->getQueryParams()['category'],"'");//$args['category'];
    	$i_package = trim($req->getQueryParams()['package'],"'");
    	$i_szone = trim($req->getQueryParams()['source_zone'],"'");
    	$i_dzone = trim($req->getQueryParams()['destination_zone'],"'");

    	$d = [
    		"source" => $i_source,
    		"destination" => $i_destination,
    		"weight" => $i_weight,
    		"category" => $i_category,
    		"package" => $i_package,
    		"szone" => $i_szone,
    		"dzone" => $i_dzone
    	];
        //forward to handlers --check handlers down
        switch ($i_category) {
        	case 'ZONAL':
        		return $this->zonal_tarrifs_handler($res,$d);
        		break;
        	case 'FTL_MANTRACK':
        		return $this->FTL_MANTRACK_tarrifs_handler($res,$d);
        		break;
        	case 'LTL_MANTRACK':
        		return $this->LTL_MANTRACK_tarrifs_handler($res,$d);
        		break;
        	case 'FULL_FLAT':
        		return $this->FULL_FLAT_tarrifs_handler($res,$d);
        		break;
        	case 'TOYOTA_DEST_BASED':
        		return $this->TOYOTA_DEST_BASED_tarrifs_handler($res,$d);
        		break;
        	case 'AZURI_DEST_BASED':
        		return $this->AZURI_DEST_BASED_tarrifs_handler($res,$d);
        		break;
        	case 'TIGO_DEST_BASED':
        		return $this->TIGO_DEST_BASED_tarrifs_handler($res,$d);
        		break;
        	case 'ZANZ_INS_DEST_BASED':
        		return $this->ZANZ_INS_DEST_BASED_tarrifs_handler($res,$d);
        		break;
        	case 'SOURCE_DEST_BASED':
        		return $this->SOURCE_DEST_BASED_tarrifs_handler($res,$d);
        		break;
        	default:
        		return $this->zonal_tarrifs_handler($res,$d);
        		break;
        }
    }



    /*
    	ZONAL TARRIF HANDLER
    */
    private function zonal_tarrifs_handler($res,$data){
    	
    	//return "zonal tariffs";
    	//ZONAL_custom_aliased_price_columns

    	$weight_data = $this->ZONAL_custom_aliased_price_columns($data["weight"]);
    	$total = 0;
    	$price = 0;
    	$extra_price_pkg = 0;
    	$lead_time = '';


    	$Tarrif = ZonalTarrif::where("package_name",$data["package"])
        				->where("destination_zone",$data["dzone"])
        				->where("weight_in_kg",$weight_data['weight_base'])
        				->get(["price as price","add_price_per_kg as extra_price_pkg","lead_time"])//price & extra_price_pkg
        				->first();

    	if($Tarrif != null){
    		//calculate
    		$price = $Tarrif->price;
    		$extra_price_pkg = $Tarrif->extra_price_pkg;
    		$total = ($price) + ($weight_data["weight_extra"] * $extra_price_pkg);
    		$lead_time = $Tarrif->lead_time;
    	}
    	return $res->withJSON([
    		"total"=>$total,
    		"price"=>$price,
    		"extra_price_pkg"=>$extra_price_pkg,
    		"base_weight"=>$weight_data['weight_base'],
    		"extra_weight"=>$weight_data['weight_extra'],
    		"lead_time" =>$lead_time
    	],200);
    }







    /*
    	LTL_MANTRACK TARRIF HANDLER
    	less track load
    */
    private function LTL_MANTRACK_tarrifs_handler($res,$data){
    	$weight_data = $this->LTL_MANTRACK_custom_aliased_price_columns($data["weight"]);
    	$total = 0;
    	$price = 0;
    	$extra_price_pkg = 0;
    	$lead_time = '';

    	//return $res->withJSON($weight_data);

    	$Tarrif = TR_SD_LTL_MANTRACK_TARRIF
    				::where("source_warehouse",$data["source"])
    				->where("destination_warehouse",$data["destination"])
    				->where("package_name",$data["package"])
    				->get($weight_data['cols'])//price & extra_price_pkg
    				->first();
    	if($Tarrif != null){
    		//calculate
    		$price = $Tarrif->price;
    		$extra_price_pkg = $Tarrif->extra_price_pkg;
    		$total = ($price) + ($weight_data["weight_extra"] * $extra_price_pkg);
    		$lead_time = $Tarrif->lead_time;
    	}
    	return $res->withJSON([
    		"total"=>$total,
    		"price"=>$price,
    		"extra_price_pkg"=>$extra_price_pkg,
    		"base_weight"=>$weight_data['weight_base'],
    		"extra_weight"=>$weight_data['weight_extra'],
    		"lead_time" =>$lead_time
    	],200);
    }












    /*
    	FTL_MANTRACK TARRIF HANDLER
    	Full truckload
    */
    private function FTL_MANTRACK_tarrifs_handler($res,$data){
    	$weight_data = $this->FTL_MANTRACK_custom_aliased_price_columns($data["weight"]);
    	$total = 0;
    	$price = 0;
    	$extra_price_pkg = 0;
    	$lead_time = '';

    	//return $res->withJSON($weight_data);

    	if($weight_data["weight_base"] != 0){
    		$Tarrif = TR_SD_FTL_MANTRACK_TARRIF
    				::where("source_warehouse",$data["source"])
    				->where("destination_warehouse",$data["destination"])
    				->where("package_name",$data["package"])
    				->get($weight_data['cols'])//price & extra_price_pkg
    				->first();

    		if($Tarrif != null){
    			//calculate
	    		$price = $Tarrif->price;
	    		$extra_price_pkg = $Tarrif->extra_price_pkg;
	    		$total = ($price) + ($weight_data["weight_extra"] * $extra_price_pkg);
	    		$lead_time = $Tarrif->lead_time;
    		}
    		

    		return $res->withJSON([
	    		"total"=>$total,
	    		"price"=>$price,
	    		"extra_price_pkg"=>$extra_price_pkg,
	    		"base_weight"=>$weight_data['weight_base'],
	    		"extra_weight"=>$weight_data['weight_extra'],
	    		"lead_time" =>$lead_time
	    	],200);
    	}else{
    		return $res->withJSON([
	    		"total"=>$total,
	    		"price"=>$price,
	    		"extra_price_pkg"=>$extra_price_pkg,
	    		"base_weight"=>$weight_data['weight_base'],
	    		"extra_weight"=>$weight_data['weight_extra'],
	    		"lead_time" =>$lead_time
	    	],200);
    	}
    }






    /*//AZURI_custom_aliased_price_columns
    	TOYOTA DEST_BASED TARRIF HANDLER
    */
    private function TOYOTA_DEST_BASED_tarrifs_handler($res,$data){
    	$weight_data = $this->TOYOTA_custom_aliased_price_columns($data["weight"]);
    	$total = 0;
    	$price = 0;
    	$extra_price_pkg = 0;
    	$lead_time = '';



    	if($weight_data["weight_base"] != 0){
    		$Tarrif = TR_DEST_TOYOTA_TARIFF
    				::where("destination_warehouse",$data["destination"])
    				->where("package_name",$data["package"])
    				->get($weight_data['cols'])//price
    				->first();
    		if($Tarrif != null){
    			//calculate
	    		$price = $Tarrif->price;
	    		$extra_price_pkg = 2500;//$Tarrif->extra_price_pkg; --given//TODO
	    		$total = ($price) + ($weight_data["weight_extra"] * $extra_price_pkg);
	    		$lead_time = $Tarrif->lead_time;
    		}
    		
    		return $res->withJSON([
	    		"total"=>$total,
	    		"price"=>$price,
	    		"extra_price_pkg"=>$extra_price_pkg,
	    		"base_weight"=>$weight_data['weight_base'],
	    		"extra_weight"=>$weight_data['weight_extra'],
	    		"lead_time" =>$lead_time
	    	],200);
    	}else{
    		return $res->withJSON([
	    		"total"=>$total,
	    		"price"=>$price,
	    		"extra_price_pkg"=>$extra_price_pkg,
	    		"base_weight"=>$weight_data['weight_base'],
	    		"extra_weight"=>$weight_data['weight_extra'],
	    		"lead_time" =>$lead_time
	    	],200);
    	}
    }






     /*//
    	AZURI DEST_BASED TARRIF HANDLER
    */
    private function AZURI_DEST_BASED_tarrifs_handler($res,$data){
    	$weight_data = $this->AZURI_custom_aliased_price_columns($data["weight"]);
    	$total = 0;
    	$price = 0;
    	$extra_price_pkg = 0;
    	$lead_time = '';


    	if($weight_data["weight_base"] != 0){
    		$Tarrif = TR_DEST_AZURI_TARIFF
    				::where("destination_warehouse",$data["destination"])
    				->where("package_name",$data["package"])
    				->get($weight_data['cols'])//price
    				->first();

    		if($Tarrif != null){
    			//calculate
	    		$price = $Tarrif->price;
	    		$extra_price_pkg = 2300;//$Tarrif->extra_price_pkg; --given//TODO
	    		$total = ($price) + ($weight_data["weight_extra"] * $extra_price_pkg);
	    		$lead_time = $Tarrif->lead_time;
    		}
    		

    		return $res->withJSON([
	    		"total"=>$total,
	    		"price"=>$price,
	    		"extra_price_pkg"=>$extra_price_pkg,
	    		"base_weight"=>$weight_data['weight_base'],
	    		"extra_weight"=>$weight_data['weight_extra'],
	    		"lead_time" =>$lead_time
	    	],200);
    	}else{
    		return $res->withJSON([
	    		"total"=>$total,
	    		"price"=>$price,
	    		"extra_price_pkg"=>$extra_price_pkg,
	    		"base_weight"=>$weight_data['weight_base'],
	    		"extra_weight"=>$weight_data['weight_extra'],
	    		"lead_time" =>$lead_time
	    	],200);
    	}
    }



     /*//
    	TIGO DEST_BASED TARRIF HANDLER
    */
    private function TIGO_DEST_BASED_tarrifs_handler($res,$data){
    	$weight_data = $this->TIGO_DEST_BASED_custom_aliased_price_columns($data["weight"]);
    	$total = 0;
    	$price = 0;
    	$extra_price_pkg = 0;
    	$lead_time = '';

    	$Tarrif = TR_TIGO_DEST_BASED_TARIFF
    				::where("destination_warehouse",$data["destination"])
    				->where("package_name",$data["package"])
    				->get($weight_data['cols'])//price
    				->first();
    	if($Tarrif != null){

    		//calculate
    		$price = $Tarrif->price;
    		$extra_price_pkg = 3500;//$Tarrif->extra_price_pkg; --given//TODO
    		$total = ($price) + ($weight_data["weight_extra"] * $extra_price_pkg);
    		$lead_time = $Tarrif->lead_time;

    		return $res->withJSON([
	    		"total"=>$total,
	    		"price"=>$price,
	    		"extra_price_pkg"=>$extra_price_pkg,
	    		"base_weight"=>$weight_data['weight_base'],
	    		"extra_weight"=>$weight_data['weight_extra'],
	    		"lead_time" =>$lead_time
	    	],200);
    	}else{
    		return $res->withJSON([
	    		"total"=>$total,
	    		"price"=>$price,
	    		"extra_price_pkg"=>$extra_price_pkg,
	    		"base_weight"=>$weight_data['weight_base'],
	    		"extra_weight"=>$weight_data['weight_extra'],
	    		"lead_time" =>$lead_time
	    	],200);
    	}
    }






     /*
    	ZANZ INS DEST_BASED TARRIF HANDLER
    */
    private function ZANZ_INS_DEST_BASED_tarrifs_handler($res,$data){
    	$weight_data = $this->ZANZ_INS_custom_aliased_price_columns($data["weight"]);
    	$total = 0;
    	$price = 0;
    	$extra_price_pkg = 0;
    	$lead_time = '';


    	if($weight_data["weight_base"] != 0){
    		$Tarrif = TR_ZANZ_INS_TARIFF
    				::where("destination_warehouse",$data["destination"])
    				->where("package_name",$data["package"])
    				->get($weight_data['cols'])//price
    				->first();

    		if($Tarrif != null){
    			//calculate
	    		$price = $Tarrif->price;
	    		$extra_price_pkg = 1500;//$Tarrif->extra_price_pkg; --given//TODO
	    		$total = ($price) + ($weight_data["weight_extra"] * $extra_price_pkg);
	    		$lead_time = $Tarrif->lead_time;
    		}
    		
    		return $res->withJSON([
	    		"total"=>$total,
	    		"price"=>$price,
	    		"extra_price_pkg"=>$extra_price_pkg,
	    		"base_weight"=>$weight_data['weight_base'],
	    		"extra_weight"=>$weight_data['weight_extra'],
	    		"lead_time" =>$lead_time
	    	],200);
    	}else{
    		return $res->withJSON([
	    		"total"=>$total,
	    		"price"=>$price,
	    		"extra_price_pkg"=>$extra_price_pkg,
	    		"base_weight"=>$weight_data['weight_base'],
	    		"extra_weight"=>$weight_data['weight_extra'],
	    		"lead_time" =>$lead_time
	    	],200);
    	}
    }



    /*//
    	FULL FLAT TARRIF HANDLER
    */
    private function FULL_FLAT_tarrifs_handler($res,$data){
    	$weight_data = $this->Full_Flat_custom_aliased_price_columns($data["weight"],$data["package"]);//
    	$total = 0;
    	$price = 0;
    	$extra_price_pkg = 0;
    	$lead_time = '';

    	$Tarrif = TR_FULL_FLAT
    				::where("package_name",$data["package"])
    				->where("weight",$weight_data['weight_base'])
    				->first();//return price and add_price_per_kg

    	if($Tarrif != null){
    		//calculate
			$price = $Tarrif->price;
			$extra_price_pkg = $Tarrif->add_price_per_kg; //--given//TODO
			$total = ($price) + ($weight_data["weight_extra"] * $extra_price_pkg);
			$lead_time = $Tarrif->lead_time;

    	}
		return $res->withJSON([
    		"total"=>$total,
    		"price"=>$price,
    		"extra_price_pkg"=>$extra_price_pkg,
    		"base_weight"=>$weight_data['weight_base'],
    		"extra_weight"=>$weight_data['weight_extra'],
    		"lead_time" =>$lead_time
    	],200);
    }





    /*
    	SOURCE_DEST_BASED TARRIF HANDLER
    */
    private function SOURCE_DEST_BASED_tarrifs_handler($res,$data){
    	return $res->withJSON($data,200);
    	//return "zonal tariffs";
    }




    

}