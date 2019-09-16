<?php
namespace App\Controllers\TARRIFS_API;

use App\Controllers\BaseController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


use App\Models\ZonalTarrif;
use App\Models\TR_SD_FTL_MANTRACK_TARRIF;
use App\Models\TR_SD_LTL_MANTRACK_TARRIF;
use App\Models\TR_DEST_TOYOTA_TARIFF;
use App\Models\TR_DEST_AZURI_TARIFF;
use App\Models\TR_ZANZ_INS_TARIFF;
use App\Models\TR_DEST_BASED_TARIFF;
use App\Models\TR_FULL_FLAT;
use App\Models\TR_TIGO_DEST_BASED_TARIFF;



class BaseTarrifController extends BaseController{

   


//


    protected function my_info($category){
    	switch ($category) {
        	case 'ZONAL':
        		return [
        			"table" => "tr_zonal_tarrifs"
        		];
        		break;
        	case 'FTL_MANTRACK':
        		return [
        			"table" => "tr_s_d_ftl_mantrack_tarrifs"
        		];
        		break;
        	case 'LTL_MANTRACK':
        		return [
        			"table" => "tr_s_d_ltl_mantrack_tarrifs"
        		];
        		break;
        	case 'FULL_FLAT':
        		return [
        			"table" => "tr_full_flat"
        		];
        		break;
        	case 'DEST_BASED':
        		return [
        			"table" => "tr_dest_based_tarrifs"
        		];
        		break;
        	case 'TOYOTA_DEST_BASED':
        		return [
        			"table" => "tr_dest_based_tarrifs"
        		];
        		break;
        	case 'AZURI_DEST_BASED':
        		return [
        			"table" => "tr_dest_based_tarrifs"
        		];
        		break;
        	case 'TIGO_DEST_BASED':
        		return [
        			"table" => "tr_dest_based_tarrifs"
        		];
        		break;
        	case 'ZANZ_INS_DEST_BASED':
        		return [
        			"table" => "tr_dest_based_tarrifs"
        		];
        		break;
        	case 'SOURCE_DEST_BASED':
        		return [
        			"table" => ""
        		];
        		break;
        	default:
        		return [
        			"table" => "tr_zonal_tarrifs"
        		];
        		break;
        }
    }



    //new tarrif  
    protected function push_new_tarrif($category,$data){
    	switch ($category) {
        	case 'ZONAL': ZonalTarrif::create($data); break;
        	case 'FTL_MANTRACK': TR_SD_FTL_MANTRACK_TARRIF::create($data); break;
        	case 'LTL_MANTRACK': TR_SD_LTL_MANTRACK_TARRIF::create($data); break;
        	case 'TOYOTA_DEST_BASED': TR_DEST_TOYOTA_TARIFF::create($data); break;
        	case 'AZURI_DEST_BASED': TR_DEST_AZURI_TARIFF::create($data); break;
        	case 'TIGO_DEST_BASED': TR_TIGO_DEST_BASED_TARIFF::create($data); break;
        	case 'ZANZ_INS_DEST_BASED': TR_ZANZ_INS_TARIFF::create($data); break;
        	case 'FULL_FLAT': TR_FULL_FLAT::create($data); break;
        	case 'SOURCE_DEST_BASED': ZonalTarrif::create($data); break;//TODO
        	case 'DEST_BASED': TR_DEST_BASED_TARIFF::create($data); break;
        	default : ZonalTarrif::create($data); break;
        }
    }

     //update_tarrif 
    protected function update_tarrif_by_category($category,$id,$data){
    	switch ($category) {
        	case 'ZONAL': ZonalTarrif::where('id',$id)->update($data); break;
        	case 'FTL_MANTRACK': TR_SD_FTL_MANTRACK_TARRIF::where('id',$id)->update($data); break;
        	case 'LTL_MANTRACK': TR_SD_LTL_MANTRACK_TARRIF::where('id',$id)->update($data); break;
        	case 'TOYOTA_DEST_BASED': TR_DEST_TOYOTA_TARIFF::where('id',$id)->update($data); break;
        	case 'AZURI_DEST_BASED': TR_DEST_AZURI_TARIFF::where('id',$id)->update($data); break;
        	case 'TIGO_DEST_BASED': TR_TIGO_DEST_BASED_TARIFF::where('id',$id)->update($data); break;
        	case 'ZANZ_INS_DEST_BASED': TR_ZANZ_INS_TARIFF::where('id',$id)->update($data); break;
        	case 'FULL_FLAT': TR_FULL_FLAT::where('id',$id)->update($data); break;
        	case 'SOURCE_DEST_BASED': ZonalTarrif::where('id',$id)->update($data); break;//TODO
        	case 'DEST_BASED': TR_DEST_BASED_TARIFF::where('id',$id)->update($data); break;
        	default : ZonalTarrif::where('id',$id)->update($data); break;
        }
    }

    protected function delete_tarrif_by_category($category,$id){
    	switch ($category) {
        	case 'ZONAL': ZonalTarrif::where('id',$id)->delete(); break;
        	case 'FTL_MANTRACK': TR_SD_FTL_MANTRACK_TARRIF::where('id',$id)->delete(); break;
        	case 'LTL_MANTRACK': TR_SD_LTL_MANTRACK_TARRIF::where('id',$id)->delete(); break;
        	case 'TOYOTA_DEST_BASED': TR_DEST_TOYOTA_TARIFF::where('id',$id)->delete(); break;
        	case 'AZURI_DEST_BASED': TR_DEST_AZURI_TARIFF::where('id',$id)->delete(); break;
        	case 'TIGO_DEST_BASED': TR_TIGO_DEST_BASED_TARIFF::where('id',$id)->delete(); break;
        	case 'ZANZ_INS_DEST_BASED': TR_ZANZ_INS_TARIFF::where('id',$id)->delete(); break;
        	case 'SOURCE_DEST_BASED': ZonalTarrif::where('id',$id)->delete(); break;//TODO
        	case 'DEST_BASED': TR_DEST_BASED_TARIFF::where('id',$id)->delete(); break;
        	case 'FULL_FLAT': TR_FULL_FLAT::where('id',$id)->delete(); break;
        	default : ZonalTarrif::where('id',$id)->delete(); break;
        }
    }












    /*
    	ZONAL custom weight
    */
    protected function ZONAL_custom_aliased_price_columns($weight){
    	$cols_array = [];//$weight = round($weight);
    	$weight_base = 0;
    	$weight_extra = 0;
    	$max_limit = 10;//not more than 10 KG
    	$remainder = 0;

    	if($weight <= $max_limit){
    		$remainder = fmod($weight, 0.5);
	    	if($remainder != 0){
	    		$to_add = 0.5 - $remainder;
	    		//add to fixed weight
	    		$weight += $to_add;
	    		$weight_base = $weight;
	    	}else{
	    		$to_add = 0;
	    		//add to fixed weight
	    		$weight += $to_add;
	    		$weight_base = $weight;
	    	}
    	}
    	else{
    		$weight_base = $max_limit;
    		$weight_extra = $weight - $max_limit;
    	}

    	

    	return [
    		"weight_base"=>$weight_base,
    		"weight_extra"=>$weight_extra,
    		"cols"=>[],//not required in zonal
    	];
    }












    /*
    	LTL_MANTRACK custom weight
    */
    protected function LTL_MANTRACK_custom_aliased_price_columns($weight){
    	$cols_array = [];//$weight = round($weight);
    	$weight_base = 0;
    	$weight_extra = 0;

    	//on normal basis
    	if($weight == 0.5 || $weight < 0.5){
    		$weight_base = 0.5;
    		array_push($cols_array, "0p5 as price");
    		array_push($cols_array, "0 as extra_price_pkg");

    	}	
    	else{
    		$weight = round($weight);
	    	if($weight > 0.5 && $weight <= 40){
	    		$weight_base = round($weight);
	    		array_push($cols_array, round($weight) . " as price");
	    		array_push($cols_array, "0 as extra_price_pkg");
	    	}
	    	//on excess
	    	else if($weight > 40 && $weight <= 49){
	    		$weight_base = 40;
	    		$weight_extra = round($weight - 40);
	    		array_push($cols_array, "40 as price");
	    		array_push($cols_array, "a41_49 as extra_price_pkg");
	    	}
	    	else if($weight == 50){
	    		$weight_base = 50;
	    		array_push($cols_array, "50 as price");
	    		array_push($cols_array, "0 as extra_price_pkg");
	    	}
	    	else if($weight >= 51 && $weight <= 499){
	    		$weight_base = 50;
	    		$weight_extra = round($weight - 50);
	    		array_push($cols_array, "50 as price");
	    		array_push($cols_array, "a51_499 as extra_price_pkg");
	    	}
	    	else if($weight == 500){
	    		$weight_base = 500;
	    		array_push($cols_array, "500 as price");
	    		array_push($cols_array, "0 as extra_price_pkg");
	    	}
	    	else if($weight >= 501 && $weight <= 999){
	    		$weight_base = 500;
	    		$weight_extra = round($weight - 500);
	    		array_push($cols_array, "500 as price");
	    		array_push($cols_array, "a501_999 as extra_price_pkg");
	    	}
	    	else if($weight == 1000){
	    		$weight_base = 1000;
	    		array_push($cols_array, "1000 as price");
	    		array_push($cols_array, "0 as extra_price_pkg");
	    	}
	    	else if($weight > 1000){
	    		$weight_base = 1000;
	    		$weight_extra = round($weight - 1000);
	    		array_push($cols_array, "1000 as price");
	    		array_push($cols_array, "a1000 as extra_price_pkg");
	    	}

    	}

    	
    	//lead time
    	array_push($cols_array, "lead_time as lead_time");

    	return ["weight_base"=>$weight_base,"weight_extra"=>$weight_extra,"cols"=>$cols_array];
    }










    /*
    	FTL_MANTRACK custom weight
    */
    protected function FTL_MANTRACK_custom_aliased_price_columns($weight){
    	$cols_array = [];
    	$weight_base = 0;
    	$weight_extra = 0;

    	//on normal basis
    	if($weight == 3000){
    		$weight_base = 3000;
    		array_push($cols_array, "3000 as price");
    		array_push($cols_array, "0 as extra_price_pkg");
    	}		
    	else if($weight == 5000){
    		$weight_base = 5000;
    		array_push($cols_array, "5000 as price");
    		array_push($cols_array, "0 as extra_price_pkg");
    	}
    	else if($weight == 10000){
    		$weight_base = 10000;
    		array_push($cols_array, "10000 as price");
    		array_push($cols_array, "0 as extra_price_pkg");
    	}
    	else if($weight == 15000){
    		$weight_base = 15000;
    		array_push($cols_array, "15000 as price");
    		array_push($cols_array, "0 as extra_price_pkg");
    	}
    	else if($weight == 20000){
    		$weight_base = 20000;
    		array_push($cols_array, "20000 as price");
    		array_push($cols_array, "0 as extra_price_pkg");
    	}
    	else if($weight == 25000){
    		$weight_base = 25000;
    		array_push($cols_array, "25000 as price");
    		array_push($cols_array, "0 as extra_price_pkg");
    	}
    	
    	//lead time
    	array_push($cols_array, "lead_time as lead_time");
    	

    	return ["weight_base"=>$weight_base,"weight_extra"=>$weight_extra,"cols"=>$cols_array];
    }






    /*
    	TOYOTA custom weight & SALUTE
    */
    protected function TOYOTA_custom_aliased_price_columns($weight){
    	$cols_array = [];//$weight = round($weight);
    	$weight_base = 0;
    	$weight_extra = 0;

    	if($weight == 0.5 || $weight < 0.5){
    		$weight_base = 0.5;
    		array_push($cols_array, "0p5 as price");
    	}	
    	$weight = round($weight);
    	if($weight == 1){
    		$weight_base = round($weight);
    		array_push($cols_array, round($weight) . " as price");
    	}
    	else if($weight == 2){
    		$weight_base = round($weight);
    		array_push($cols_array, round($weight) . " as price");
    	}
    	else if($weight == 3){
    		$weight_base = round($weight);
    		array_push($cols_array, round($weight) . " as price");
    	}
    	else if($weight == 4){
    		$weight_base = round($weight);
    		array_push($cols_array, round($weight) . " as price");
    	}
    	else if($weight == 5){
    		$weight_base = round($weight);
    		array_push($cols_array, round($weight) . " as price");
    	}
    	else if($weight > 5){
    		$weight_base = round($weight);
    		$weight_extra = $weight - 5;
    		array_push($cols_array,"5 as price");
    	}
    	//on

    	//lead time
    	array_push($cols_array, "lead_time as lead_time");
    	

    	return ["weight_base"=>$weight_base,"weight_extra"=>$weight_extra,"cols"=>$cols_array];
    }


    /*AZURI_custom_aliased_price_columns
    	AZURI custom weight
    */
    protected function AZURI_custom_aliased_price_columns($weight){
    	$cols_array = [];//$weight = round($weight);
    	$weight_base = 0;
    	$weight_extra = 0;

    	if($weight < 0.5){
    		$weight_base = 0.5;
    		array_push($cols_array, "0p5_10 as price");
    	}	

    	$weight = round($weight);


    	if($weight >= 0.5 && $weight <= 10){
    		$weight_base = round($weight);
    		array_push($cols_array,"0p5_10 as price");
    	}
    	else if($weight >= 11 && $weight <= 20){
    		$weight_base = round($weight);
    		array_push($cols_array,"11_20 as price");
    	}
    	else if($weight >= 21 && $weight <= 50){
    		$weight_base = round($weight);
    		array_push($cols_array,"21_50 as price");
    	}
    	else if($weight >= 51 && $weight <= 100){
    		$weight_base = round($weight);
    		array_push($cols_array,"51_100 as price");
    	}
    	else if($weight >= 101 && $weight <= 200){
    		$weight_base = round($weight);
    		array_push($cols_array,"101_200 as price");
    	}
    	else if($weight > 200){
    		$weight_base = round($weight);
    		$weight_extra = $weight - 200;
    		array_push($cols_array,"101_200 as price");
    	}
    	//on

    	//lead time
    	array_push($cols_array, "lead_time as lead_time");
    	

    	return ["weight_base"=>$weight_base,"weight_extra"=>$weight_extra,"cols"=>$cols_array];
    }




     /*
    	TIGO custom weight
    	cols and extra weight
    */
    protected function TIGO_DEST_BASED_custom_aliased_price_columns($weight){
    	$cols_array = [];//$weight = round($weight);
    	$weight_base = 0;
    	$weight_extra = 0;

    	if($weight < 0.5){
    		$weight = 0.5;
    	}

    	if($weight >= 0.5 && $weight <= 5){
    		$weight_base = 5;
    		array_push($cols_array,"0p5_5 as price");
    	}else if($weight >= 5.1 && $weight <= 15){
    		$weight_base = 15;
    		array_push($cols_array,"5p1_15 as price");
    	}
    	else if($weight >= 15.1 && $weight <= 30){
    		$weight_base = 30;
    		array_push($cols_array,"15p1_30 as price");
    	}
    	else if($weight >= 30.1 && $weight <= 50){
    		$weight_base = 50;
    		array_push($cols_array,"30p1_50 as price");
    	}
    	else if($weight >= 50.1 && $weight <= 100){
    		$weight_base = 100;
    		array_push($cols_array,"50p1_100 as price");
    	}
    	else{
    		//exceed
    		$weight_base = 100;
    		array_push($cols_array,"50p1_100 as price");
    		$weight_extra = $weight - 100;
    	}

    	//lead time
    	array_push($cols_array, "lead_time as lead_time");
    	
    	return ["weight_base"=>$weight_base,"weight_extra"=>$weight_extra,"cols"=>$cols_array];
    }



    /*
    	ZANZ_INS custom weight
    */
    protected function ZANZ_INS_custom_aliased_price_columns($weight){
    	$cols_array = [];//$weight = round($weight);
    	$weight_base = 0;
    	$weight_extra = 0;

    	if($weight < 0.5){
    		$weight = 0.5;
    		$weight_base = 0.5;
    		array_push($cols_array, "0p5 as price");
    	}	

    	//most correct 
    	$remainder = fmod($weight,0.5);
    	$w2Add = $remainder == 0 ? 0 : (0.5 - $remainder);
    	$weight = $weight + $w2Add;


    	switch ($weight) {
    		case 0.5: { $weight_base = $weight;array_push($cols_array,"0p5 as price");}break;
    		case 1: { $weight_base = $weight;array_push($cols_array,"1 as price");}break;
    		case 1.5: { $weight_base = $weight;array_push($cols_array,"1p5 as price");}break;
    		case 2: { $weight_base = $weight;array_push($cols_array,"2 as price");}break;
    		case 2.5: { $weight_base = $weight;array_push($cols_array,"2p5 as price");}break;
    		case 3: { $weight_base = $weight;array_push($cols_array,"3 as price");}break;
    		case 3.5: { $weight_base = $weight;array_push($cols_array,"3p5 as price");}break;
    		case 4: { $weight_base = $weight;array_push($cols_array,"4 as price");}break;
    		case 4.5: { $weight_base = $weight;array_push($cols_array,"4p5 as price");}break;
    		case 5: { $weight_base = $weight;array_push($cols_array,"5 as price");}break;
    		case 5.5: { $weight_base = $weight;array_push($cols_array,"5p5 as price");}break;
    		case 6: { $weight_base = $weight;array_push($cols_array,"6 as price");}break;
    		case 6.5: { $weight_base = $weight;array_push($cols_array,"6p5 as price");}break;
    		case 7: { $weight_base = $weight;array_push($cols_array,"7 as price");}break;
    		case 7.5: { $weight_base = $weight;array_push($cols_array,"7p5 as price");}break;
    		case 8: { $weight_base = $weight;array_push($cols_array,"8 as price");}break;
    		case 8.5: { $weight_base = $weight;array_push($cols_array,"8p5 as price");}break;
    		case 9: { $weight_base = $weight;array_push($cols_array,"9 as price");}break;
    		case 9.5: { $weight_base = $weight;array_push($cols_array,"9p5 as price");}break;
    		case 10: { $weight_base = $weight;array_push($cols_array,"10 as price");}break;
    		//exceed
    		default:{
    			$weight_base = 10;
    			$weight -=$remainder;
    			$weight_extra = $weight - 10;
    			array_push($cols_array,"10 as price");
    			break;
    		}
    	}
    	//lead time
    	array_push($cols_array, "lead_time as lead_time");
    	
    	return ["weight_base"=>$weight_base,"weight_extra"=>$weight_extra,"cols"=>$cols_array];
    }







    /*
    	Full flat custom weight
    */
    protected function Full_Flat_custom_aliased_price_columns($weight,$package){
    	$cols_array = [];//$weight = round($weight);
    	$weight_base = "0";
    	$weight_extra = 0;

    	switch ($package) {
    		case 'TIGO':
    			if($weight <= 10)
    				$weight_base = "0_10";
    			else if($weight > 10 && $weight <= 20)
    				$weight_base = "0_20";
    			else if($weight > 20 && $weight <= 30)
    				$weight_base = "0_30";
    			else if($weight > 30 && $weight <= 40)
    				$weight_base = "0_40";
    			else if($weight > 40 && $weight <= 50)
    				$weight_base = "0_50";
    			//extra weight
    			else{
    				$weight_base = "0_50";
    				$weight_extra = $weight - 50;
    			}
    			break;
    		default:
    			$weight_base = $weight."";
    			break;
    	}
    	//lead time
    	array_push($cols_array, "lead_time as lead_time");
    	
    	return ["weight_base"=>$weight_base,"weight_extra"=>$weight_extra,"cols"=>$cols_array];

    }











}


?>