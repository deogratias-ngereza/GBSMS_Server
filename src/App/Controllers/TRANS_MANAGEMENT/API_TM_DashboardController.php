<?php
namespace App\Controllers\TRANS_MANAGEMENT;

use Illuminate\Database\Capsule\Manager as DB;

use App\Controllers\BaseController;
use App\Controllers\TRANS_MANAGEMENT\SystemHistoryController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use App\Models\TM_Driver;
use App\Models\TM_Vehicle;
use App\Models\TM_Trailer;
use App\Models\TM_Order;
use App\Models\TM_Worker;
use App\Models\TmExchangeRate;
use App\Models\TM_VehiclePermitType;
use App\Models\TM_VehiclePermit;
use App\Models\TM_DriverLoan;

class API_TM_DashboardController extends BaseController{

    protected $recorder;
    public function __construct(){
        $this->recorder = new SystemHistoryController();
    }

    
    //summary
    public function summary($req,$res,$args){

        $total_drivers = TM_Driver::count();
        $total_vehicles = TM_Vehicle::count();
        $total_trailers = TM_Trailer::count(); 
        $total_orders = TM_Order::count();
        $current_exch_rates = TmExchangeRate::all();
        $available_permits = TM_VehiclePermitType::all();

        //get vehicles count with their groups
        $vehicle_pos_summary = DB::select(DB::raw('SELECT COUNT(current_vehicle_status) AS counts, current_vehicle_status AS status FROM tm_vehicles GROUP BY current_vehicle_status'));
        $free_n_alloc_vehicles = DB::select(DB::raw('SELECT COUNT(alloc_status) AS counts, alloc_status AS status FROM tm_vehicles GROUP BY alloc_status'));

        //expired lisence & passports
        $total_exp_drivers_licenses = TM_Driver::where('license_exp_date','<',$this->get_current_date('yyyy-mm-dd'))->count();
        $total_exp_drivers_passports = TM_Driver::where('passport_exp_date','<',$this->get_current_date('yyyy-mm-dd'))->count();



        $truck_permits_statuses = [];
        $trailer_permits_statuses = [];

        //get expired permits types
        for($i = 0; $i < sizeof($available_permits);$i++){
            $permit_name = $available_permits[$i]['name'];
            $permit_id = $available_permits[$i]['id'];

            //for truck
            $single_permit_count_for_truck = TM_VehiclePermit::with('permit')
                ->where('permit_for','TRUCK')
                ->where('permit_id',$permit_id)
                ->where('end_date','<=',$this->get_current_date('yyyy-mm-dd'))
                ->count();
            array_push($truck_permits_statuses, ["single_permit_count_for_truck"=>$single_permit_count_for_truck,"permit_name"=>$permit_name]);

            //for trailers
            $single_permit_count_for_trailer = TM_VehiclePermit::with('permit')
                ->where('permit_for','TRAILER')
                ->where('permit_id',$permit_id)
                ->where('end_date','<=',$this->get_current_date('yyyy-mm-dd'))
                ->count();
            array_push($trailer_permits_statuses, ["single_permit_count_for_trailer"=>$single_permit_count_for_trailer,"permit_name"=>$permit_name]);
        }


        

        //calc total wealth --> multiple currency.

        /*$sample_orders = InvOrder::with(['supplier'])->skip(0)->take(5)->get();
        $sample_ofs_items = InvItem::where('current_stock_qty',0)->skip(0)->take(5)->get();
        $total_ofs_items = InvItem::where('current_stock_qty',0)->count();*/
        
        $data = [
            "msg_data" => [
            	"total_drivers"=>$total_drivers,
            	"total_vehicles"=>$total_vehicles,
            	"total_trailers"=>$total_trailers,
            	"total_orders"=>$total_orders, 
            	"current_exch_rates"=>$current_exch_rates,
            	"vehicle_pos_summary"=>$vehicle_pos_summary,
            	"free_n_alloc_vehicles"=>$free_n_alloc_vehicles,
                "total_exp_drivers_licenses"=>$total_exp_drivers_licenses,
                "total_exp_drivers_passports"=>$total_exp_drivers_passports,
                "truck_permits_statuses" => $truck_permits_statuses,
                "trailer_permits_statuses" => $trailer_permits_statuses
            ],
            "msg_status" => "OK"
        ];
        return $res->withJSON($data,200);
    }






}