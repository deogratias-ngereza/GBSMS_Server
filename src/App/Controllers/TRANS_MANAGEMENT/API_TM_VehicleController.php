<?php
namespace App\Controllers\TRANS_MANAGEMENT;

use App\Controllers\BaseController;
use App\Controllers\TRANS_MANAGEMENT\SystemHistoryController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use App\Models\TM_Vehicle;
use App\Models\TM_Driver;

class API_TM_VehicleController extends BaseController{
	protected $recorder;
	public function __construct(){
		$this->recorder = new SystemHistoryController();
	}

	
	//tbl fields
	public function tbl_fields($req,$res,$args){
        $TBL = new TM_Vehicle;
        return $res->withJSON($TBL->tbl_fields(),200);
    }

    
    //all
    public function all($req,$res,$args){
        $TM_Vehicle = TM_Vehicle::all();
        $data = [
            "msg_data" => $TM_Vehicle,
            "msg_status" => "OK"
        ];
        return $res->withJSON($data,200);
        //return $res->withJSON($TM_Vehicle,200);
    }


     //get_single vehicle
    public function single_vehicle_details($req,$res,$args){
        $TM_Vehicle = TM_Vehicle::where("id","=",$args['id'])->with(['driver'])->first();
        $data = [
            "msg_data" => $TM_Vehicle,
            "msg_status" => "OK"
        ];
        return $res->withJSON($data,200);
    }


      //TODO:: all free vehicle unallocated,on return,available with no problems/issues + trailers
    public function old_all_free_vehicle_2_allocate($req,$res,$args){
        $rawList = TM_Vehicle::where('alloc_status','FREE')
                    ->with(['trailers','driver'])->get();
        
         $TrucksWithTrailers = [];

        for ($i=0; $i < sizeof($rawList); $i++) { 
            
            //for a truck
            $vehicle_reg_card = $rawList[$i]->vehicle_reg_card;

            //base on product capacity
            $total_capacity = $rawList[$i]->total_capacity;
            $total_capacity_pms = $rawList[$i]->total_capacity_pms;
            $total_capacity_ago = $rawList[$i]->total_capacity_ago;
            $total_capacity_ik = $rawList[$i]->total_capacity_ik;
            $total_capacity_jet = $rawList[$i]->total_capacity_jet;
            $total_capacity_lpg = $rawList[$i]->total_capacity_lpg;
            $total_capacity_other = $rawList[$i]->total_capacity_other;
            $trailers_list = "";
            $driver = $rawList[$i]->driver;

            //base on compantments
            $truck_tanker_comp1 = $rawList[$i]->tanker_comp1;
            $truck_tanker_comp2 = $rawList[$i]->tanker_comp2;
            $truck_tanker_comp3 = $rawList[$i]->tanker_comp3;
            $truck_tanker_comp4 = $rawList[$i]->tanker_comp4;
            $truck_tanker_comp5 = $rawList[$i]->tanker_comp5;
            $truck_total_comp = $rawList[$i]->tanker_total_comp_capacity;

            $trailer_comp_capacities = [];


            //add trailers total to vehicle
            if(sizeof($rawList[$i]->trailers) != 0 ){
                //array_push($TrucksWithTrailers, ["trailer"=>$rawList[$i]->trailers]);

                $trailer_comp_capacities = [];

                for($j = 0 ; $j < sizeof($rawList[$i]->trailers) ; $j++){
                    $trailers_list .= "/";
                    $trailers_list .= $rawList[$i]->trailers[$j]->vehicle_reg_card;
                    
                    //for trailer prod capacity
                    $total_capacity += $rawList[$i]->trailers[$j]->total_capacity;
                    $total_capacity_pms += $rawList[$i]->trailers[$j]->total_capacity_pms;
                    $total_capacity_ago += $rawList[$i]->trailers[$j]->total_capacity_ago;
                    $total_capacity_ik += $rawList[$i]->trailers[$j]->total_capacity_ik;
                    $total_capacity_jet += $rawList[$i]->trailers[$j]->total_capacity_jet;
                    $total_capacity_lpg += $rawList[$i]->trailers[$j]->total_capacity_lpg;
                    $total_capacity_other += $rawList[$i]->trailers[$j]->total_capacity_other;

                    $trailer_total_comp = $rawList[$i]->trailers[$j]->tanker_total_comp_capacity;
                    //for trailer tanker compantments
                    $trailer_tanker_cap = [
                        "trailer_tanker_comp1" => $rawList[$i]->trailers[$j]->tanker_comp1,
                        "trailer_tanker_comp2" => $rawList[$i]->trailers[$j]->tanker_comp2,
                        "trailer_tanker_comp3" => $rawList[$i]->trailers[$j]->tanker_comp3,
                        "trailer_tanker_comp4" => $rawList[$i]->trailers[$j]->tanker_comp4,
                        "trailer_tanker_comp5" => $rawList[$i]->trailers[$j]->tanker_comp5,
                        "trailer_tanker_comp6" => $rawList[$i]->trailers[$j]->tanker_comp6,
                        "trailer_tanker_comp7" => $rawList[$i]->trailers[$j]->tanker_comp7,
                        "trailer_tanker_comp8" => $rawList[$i]->trailers[$j]->tanker_comp8,
                        "trailer_total_comp" => $rawList[$i]->trailers[$j]->tanker_total_comp_capacity
                    ];
                    array_push($trailer_comp_capacities, $trailer_tanker_cap);
                }
            }else{

            }
            $dt = [
                "vehicle_reg_card" => $vehicle_reg_card,
                "trailers_list" =>$trailers_list,
                "total_capacity" => $total_capacity,
                "total_capacity_pms" => $total_capacity_pms,
                "total_capacity_ago" => $total_capacity_ago,
                "total_capacity_ik" => $total_capacity_ik,
                "total_capacity_jet" => $total_capacity_jet,
                "total_capacity_lpg" => $total_capacity_lpg,
                "total_capacity_other" => $total_capacity_other,
                "truck_tanker_comp1"=>$truck_tanker_comp1,
                "truck_tanker_comp2"=>$truck_tanker_comp2,
                "truck_tanker_comp3"=>$truck_tanker_comp3,
                "truck_tanker_comp4"=>$truck_tanker_comp4,
                "truck_tanker_comp5"=>$truck_tanker_comp5,
                "truck_total_comp"=>$truck_total_comp,
                "trailer_comp_capacities"=>$trailer_comp_capacities,
                "driver" => $driver
            ];
            array_push($TrucksWithTrailers, $dt);
        }
        $data = [
            "msg_data" => $TrucksWithTrailers,
            "msg_status" => "OK"
        ];
        return $res->withJSON($data,200);
    }





    //find vehicle details from this list of vehicle array [1,2]
    public function get_details_for_vehicles_id_list($req,$res,$args){
        $list = $req->getParsedBody();
        $rawList = TM_Vehicle::whereIn('id',$list)
                    ->with(['trailers','driver'])->get();

        $TrucksWithTrailers = [];

        for ($i=0; $i < sizeof($rawList); $i++) { 
            
            //for a truck
            $vehicle_reg_card = $rawList[$i]->vehicle_reg_card;
            $vehicle_id = $rawList[$i]->id;

            //base on product capacity
            $total_capacity = $rawList[$i]->total_capacity;
            $total_capacity_pms = $rawList[$i]->total_capacity_pms;
            $total_capacity_ago = $rawList[$i]->total_capacity_ago;
            $total_capacity_ik = $rawList[$i]->total_capacity_ik;
            $total_capacity_jet = $rawList[$i]->total_capacity_jet;
            $total_capacity_lpg = $rawList[$i]->total_capacity_lpg;
            $total_capacity_other = $rawList[$i]->total_capacity_other;
            $trailers_list = "";
            $driver = $rawList[$i]->driver;

            //truck only prod capacities
            $truck_total_capacity_pms = $rawList[$i]->total_capacity_pms;
            $truck_total_capacity_ago = $rawList[$i]->total_capacity_ago;
            $truck_total_capacity_ik = $rawList[$i]->total_capacity_ik;
            $truck_total_capacity_jet = $rawList[$i]->total_capacity_jet;
            $truck_total_capacity_lpg = $rawList[$i]->total_capacity_lpg;
            $truck_total_capacity_other = $rawList[$i]->total_capacity_other;

            //base on compantments
            $truck_tanker_comp1 = $rawList[$i]->tanker_comp1;
            $truck_tanker_comp2 = $rawList[$i]->tanker_comp2;
            $truck_tanker_comp3 = $rawList[$i]->tanker_comp3;
            $truck_tanker_comp4 = $rawList[$i]->tanker_comp4;
            $truck_tanker_comp5 = $rawList[$i]->tanker_comp5;
            $truck_total_comp = $rawList[$i]->tanker_total_comp_capacity;

            $trailer_comp_capacities = [];


            //add trailers total to vehicle
            if(sizeof($rawList[$i]->trailers) != 0 ){
                //array_push($TrucksWithTrailers, ["trailer"=>$rawList[$i]->trailers]);

                $trailer_comp_capacities = [];

                for($j = 0 ; $j < sizeof($rawList[$i]->trailers) ; $j++){
                    $trailers_list .= "/";
                    $trailers_list .= $rawList[$i]->trailers[$j]->vehicle_reg_card;
                    
                    //for trailer prod capacity
                    $total_capacity += $rawList[$i]->trailers[$j]->total_capacity;
                    $total_capacity_pms += $rawList[$i]->trailers[$j]->total_capacity_pms;
                    $total_capacity_ago += $rawList[$i]->trailers[$j]->total_capacity_ago;
                    $total_capacity_ik += $rawList[$i]->trailers[$j]->total_capacity_ik;
                    $total_capacity_jet += $rawList[$i]->trailers[$j]->total_capacity_jet;
                    $total_capacity_lpg += $rawList[$i]->trailers[$j]->total_capacity_lpg;
                    $total_capacity_other += $rawList[$i]->trailers[$j]->total_capacity_other;

                    $trailer_total_comp = $rawList[$i]->trailers[$j]->tanker_total_comp_capacity;
                    //for trailer tanker compantments
                    $trailer_tanker_cap = [
                        "trailer_id" => $rawList[$i]->trailers[$j]->id,
                        "trailer_name" => $rawList[$i]->trailers[$j]->vehicle_reg_card,
                        "trailer_tanker_comp1" => $rawList[$i]->trailers[$j]->tanker_comp1,
                        "trailer_tanker_comp2" => $rawList[$i]->trailers[$j]->tanker_comp2,
                        "trailer_tanker_comp3" => $rawList[$i]->trailers[$j]->tanker_comp3,
                        "trailer_tanker_comp4" => $rawList[$i]->trailers[$j]->tanker_comp4,
                        "trailer_tanker_comp5" => $rawList[$i]->trailers[$j]->tanker_comp5,
                        "trailer_tanker_comp6" => $rawList[$i]->trailers[$j]->tanker_comp6,
                        "trailer_tanker_comp7" => $rawList[$i]->trailers[$j]->tanker_comp7,
                        "trailer_tanker_comp8" => $rawList[$i]->trailers[$j]->tanker_comp8,
                        "trailer_tanker_comp9" => $rawList[$i]->trailers[$j]->tanker_comp9,
                        "trailer_tanker_comp10" => $rawList[$i]->trailers[$j]->tanker_comp10,
                        "trailer_total_comp" => $rawList[$i]->trailers[$j]->tanker_total_comp_capacity,
                        "total_trailer_capacity_pms"=> $rawList[$i]->trailers[$j]->total_capacity_pms,
                        "total_trailer_capacity_ago"=> $rawList[$i]->trailers[$j]->total_capacity_ago,
                        "total_trailer_capacity_ik"=> $rawList[$i]->trailers[$j]->total_capacity_ik,
                        "total_trailer_capacity_jet"=> $rawList[$i]->trailers[$j]->total_capacity_jet,
                        "total_trailer_capacity_lpg"=> $rawList[$i]->trailers[$j]->total_capacity_lpg,
                        "total_trailer_capacity_other"=> $rawList[$i]->trailers[$j]->total_capacity_other
                    ];
                    array_push($trailer_comp_capacities, $trailer_tanker_cap);
                }
            }else{

            }
            $dt = [
                "vehicle_reg_card" => $vehicle_reg_card,
                "vehicle_id" => $vehicle_id,
                "trailers_list" =>$trailers_list,
                "total_capacity" => $total_capacity,
                "total_capacity_pms" => $total_capacity_pms,
                "total_capacity_ago" => $total_capacity_ago,
                "total_capacity_ik" => $total_capacity_ik,
                "total_capacity_jet" => $total_capacity_jet,
                "total_capacity_lpg" => $total_capacity_lpg,
                "total_capacity_other" => $total_capacity_other,
                "truck_tanker_comp1"=>$truck_tanker_comp1,
                "truck_tanker_comp2"=>$truck_tanker_comp2,
                "truck_tanker_comp3"=>$truck_tanker_comp3,
                "truck_tanker_comp4"=>$truck_tanker_comp4,
                "truck_tanker_comp5"=>$truck_tanker_comp5,
                "truck_total_comp"=>$truck_total_comp,
                "truck_total_capacity_pms"=>$truck_total_capacity_pms,
                "truck_total_capacity_ago"=>$truck_total_capacity_ago,
                "truck_total_capacity_ik"=>$truck_total_capacity_ik,
                "truck_total_capacity_jet"=>$truck_total_capacity_jet,
                "truck_total_capacity_lpg"=>$truck_total_capacity_lpg,
                "truck_total_capacity_other"=>$truck_total_capacity_other,
                "trailer_comp_capacities"=>$trailer_comp_capacities,
                "driver" => $driver
            ];
            array_push($TrucksWithTrailers, $dt);
        }



        $data = [
            "msg_data" => $TrucksWithTrailers,
            "msg_status" => "OK"
        ];
        return $res->withJSON($data,200);
    }




     //TODO:: all free vehicle unallocated,on return,available with no problems/issues + trailers
    public function all_free_vehicle_2_allocate($req,$res,$args){
        $rawList = TM_Vehicle::where('alloc_status','FREE')
        			->with(['trailers','driver'])->get();

        $TrucksWithTrailers = [];

        for ($i=0; $i < sizeof($rawList); $i++) { 
        	
        	//for a truck
        	$vehicle_reg_card = $rawList[$i]->vehicle_reg_card;
            $vehicle_id = $rawList[$i]->id;

            //base on product capacity
        	$total_capacity = $rawList[$i]->total_capacity;
        	$total_capacity_pms = $rawList[$i]->total_capacity_pms;
        	$total_capacity_ago = $rawList[$i]->total_capacity_ago;
        	$total_capacity_ik = $rawList[$i]->total_capacity_ik;
        	$total_capacity_jet = $rawList[$i]->total_capacity_jet;
        	$total_capacity_lpg = $rawList[$i]->total_capacity_lpg;
        	$total_capacity_other = $rawList[$i]->total_capacity_other;
        	$trailers_list = "";
        	$driver = $rawList[$i]->driver;

            //truck only prod capacities
            $truck_total_capacity_pms = $rawList[$i]->total_capacity_pms;
            $truck_total_capacity_ago = $rawList[$i]->total_capacity_ago;
            $truck_total_capacity_ik = $rawList[$i]->total_capacity_ik;
            $truck_total_capacity_jet = $rawList[$i]->total_capacity_jet;
            $truck_total_capacity_lpg = $rawList[$i]->total_capacity_lpg;
            $truck_total_capacity_other = $rawList[$i]->total_capacity_other;

            //base on compantments
            $truck_tanker_comp1 = $rawList[$i]->tanker_comp1;
            $truck_tanker_comp2 = $rawList[$i]->tanker_comp2;
            $truck_tanker_comp3 = $rawList[$i]->tanker_comp3;
            $truck_tanker_comp4 = $rawList[$i]->tanker_comp4;
            $truck_tanker_comp5 = $rawList[$i]->tanker_comp5;
            $truck_total_comp = $rawList[$i]->tanker_total_comp_capacity;

            $trailer_comp_capacities = [];


        	//add trailers total to vehicle
        	if(sizeof($rawList[$i]->trailers) != 0 ){
        		//array_push($TrucksWithTrailers, ["trailer"=>$rawList[$i]->trailers]);

                $trailer_comp_capacities = [];

        		for($j = 0 ; $j < sizeof($rawList[$i]->trailers) ; $j++){
        			$trailers_list .= "/";
        			$trailers_list .= $rawList[$i]->trailers[$j]->vehicle_reg_card;
        			
                    //for trailer prod capacity
                    $total_capacity += $rawList[$i]->trailers[$j]->total_capacity;
        			$total_capacity_pms += $rawList[$i]->trailers[$j]->total_capacity_pms;
        			$total_capacity_ago += $rawList[$i]->trailers[$j]->total_capacity_ago;
        			$total_capacity_ik += $rawList[$i]->trailers[$j]->total_capacity_ik;
        			$total_capacity_jet += $rawList[$i]->trailers[$j]->total_capacity_jet;
        			$total_capacity_lpg += $rawList[$i]->trailers[$j]->total_capacity_lpg;
        			$total_capacity_other += $rawList[$i]->trailers[$j]->total_capacity_other;

                    $trailer_total_comp = $rawList[$i]->trailers[$j]->tanker_total_comp_capacity;
                    //for trailer tanker compantments
                    $trailer_tanker_cap = [
                        "trailer_id" => $rawList[$i]->trailers[$j]->id,
                        "trailer_name" => $rawList[$i]->trailers[$j]->vehicle_reg_card,
                        "trailer_tanker_comp1" => $rawList[$i]->trailers[$j]->tanker_comp1,
                        "trailer_tanker_comp2" => $rawList[$i]->trailers[$j]->tanker_comp2,
                        "trailer_tanker_comp3" => $rawList[$i]->trailers[$j]->tanker_comp3,
                        "trailer_tanker_comp4" => $rawList[$i]->trailers[$j]->tanker_comp4,
                        "trailer_tanker_comp5" => $rawList[$i]->trailers[$j]->tanker_comp5,
                        "trailer_tanker_comp6" => $rawList[$i]->trailers[$j]->tanker_comp6,
                        "trailer_tanker_comp7" => $rawList[$i]->trailers[$j]->tanker_comp7,
                        "trailer_tanker_comp8" => $rawList[$i]->trailers[$j]->tanker_comp8,
                        "trailer_tanker_comp9" => $rawList[$i]->trailers[$j]->tanker_comp9,
                        "trailer_tanker_comp10" => $rawList[$i]->trailers[$j]->tanker_comp10,
                        "trailer_total_comp" => $rawList[$i]->trailers[$j]->tanker_total_comp_capacity,
                        "total_trailer_capacity_pms"=> $rawList[$i]->trailers[$j]->total_capacity_pms,
                        "total_trailer_capacity_ago"=> $rawList[$i]->trailers[$j]->total_capacity_ago,
                        "total_trailer_capacity_ik"=> $rawList[$i]->trailers[$j]->total_capacity_ik,
                        "total_trailer_capacity_jet"=> $rawList[$i]->trailers[$j]->total_capacity_jet,
                        "total_trailer_capacity_lpg"=> $rawList[$i]->trailers[$j]->total_capacity_lpg,
                        "total_trailer_capacity_other"=> $rawList[$i]->trailers[$j]->total_capacity_other
                    ];
                    array_push($trailer_comp_capacities, $trailer_tanker_cap);
        		}
        	}else{

        	}
        	$dt = [
        		"vehicle_reg_card" => $vehicle_reg_card,
                "vehicle_id" => $vehicle_id,
        		"trailers_list" =>$trailers_list,
        		"total_capacity" => $total_capacity,
        		"total_capacity_pms" => $total_capacity_pms,
        		"total_capacity_ago" => $total_capacity_ago,
        		"total_capacity_ik" => $total_capacity_ik,
        		"total_capacity_jet" => $total_capacity_jet,
        		"total_capacity_lpg" => $total_capacity_lpg,
        		"total_capacity_other" => $total_capacity_other,
                "truck_tanker_comp1"=>$truck_tanker_comp1,
                "truck_tanker_comp2"=>$truck_tanker_comp2,
                "truck_tanker_comp3"=>$truck_tanker_comp3,
                "truck_tanker_comp4"=>$truck_tanker_comp4,
                "truck_tanker_comp5"=>$truck_tanker_comp5,
                "truck_total_comp"=>$truck_total_comp,
                "truck_total_capacity_pms"=>$truck_total_capacity_pms,
                "truck_total_capacity_ago"=>$truck_total_capacity_ago,
                "truck_total_capacity_ik"=>$truck_total_capacity_ik,
                "truck_total_capacity_jet"=>$truck_total_capacity_jet,
                "truck_total_capacity_lpg"=>$truck_total_capacity_lpg,
                "truck_total_capacity_other"=>$truck_total_capacity_other,
                "trailer_comp_capacities"=>$trailer_comp_capacities,
        		"driver" => $driver
        	];
        	array_push($TrucksWithTrailers, $dt);
        }



        $data = [
            "msg_data" => $TrucksWithTrailers,
            "msg_status" => "OK"
        ];
        return $res->withJSON($data,200);
    }


    public function assign_driver($req,$res,$args){
    	$new_driver_id = $req->getParsedBody()['new_driver_id'];
    	$old_driver_id = $req->getParsedBody()['old_driver_id'];
    	$vehicle_id = $args['vehicle_id'];

    	//set the current driver id to a given vehicle..
    	$vehicle = TM_Vehicle::find($vehicle_id);
    	$vehicle->current_driver_id = $new_driver_id;
    	$vehicle->save();

    	//set previous driver alloca status as free (it may be a neg values;
    	$old_driver = TM_Driver::find($old_driver_id);
    	if($old_driver != null){
    		$old_driver->alloc_status = "FREE";
    		$old_driver->save();
    	}

    	//set new driver alloca status as Allocated
    	$new_driver = TM_Driver::find($new_driver_id);
    	$new_driver->alloc_status = "ALLOCATED";
    	$new_driver->save();

    	$data = [
            "msg_data" => $new_driver,
            "msg_status" => "OK"
        ];
        return $res->withJSON($data,200);
    }

    public function remove_vehicles_driver($req,$res,$args){
    	$vehicle_id = $args['vehicle_id'];
    	$old_driver_id = $req->getParsedBody()['old_driver_id'];

    	//now remove current_driver_id from vehicle
    	$vehicle = TM_Vehicle::find($vehicle_id);
    	$vehicle->current_driver_id = -1;//back to basics
    	$vehicle->save();

    	//set previous driver alloca status as free (it may be a neg values;
    	$old_driver = TM_Driver::find($old_driver_id);
    	if($old_driver != null){
    		$old_driver->alloc_status = "FREE";
    		$old_driver->save();
    	}
    	$data = [
            "msg_data" => "DRIVER REMOVED",
            "msg_status" => "OK"
        ];
        return $res->withJSON($data,200);
    }









     //get delete
	public function delete($req,$res,$args){
		$TM_Vehicle = TM_Vehicle::where('id','=',$args['id'])->first();
		if(sizeof($TM_Vehicle) == 0){
			$data = [ "msg_data" => "ALREADY DELETED","msg_status" => "FAILED"];
			return $res->withJSON($data,401);
		}
		$TM_Vehicle->delete();
		$data = ["msg_data" => "DATA DELETED","msg_status" => "OK"];
		return $res->withJSON($data,200);
	}

	//insert
	public function insert($req,$res,$args){
		$TM_Vehicle = TM_Vehicle::create($req->getParsedBody());
		$data = [
			"msg_data" => TM_Vehicle::all()->last(),
			"msg_status" => $TM_Vehicle == null ? "FAIL TO INSERT" :"OK"
		];
		//return $res->withJSON($data,200);
		return $res->withJSON(TM_Vehicle::all()->last(),200);
	}

	//update
	public function update($req,$res,$args){
		$updates = $req->getParsedBody();
		$update_status = TM_Vehicle::where('id',$args['id'])
						->update($updates);
		$results = TM_Vehicle::where('id',$args['id'])->first();
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
		$TM_Vehicle = TM_Vehicle::whereRaw("id LIKE '%".$key."%'")->get();
		$data = [
			"msg_data" => $TM_Vehicle,
			"msg_status" => sizeof($TM_Vehicle) == 0 ? "NO RESULTS FOUND" :"OK"
		];
		//return $res->withJSON($data,200);
		return $res->withJSON($TM_Vehicle,200);
	}

}