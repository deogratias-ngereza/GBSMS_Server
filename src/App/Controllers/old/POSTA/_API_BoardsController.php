<?php
namespace App\Controllers\POSTA;

use App\Controllers\BaseController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use Illuminate\Database\Capsule\Manager as DB;

use App\Models\IOArrival;
use App\Models\IODeparture;

class API_BoardsController extends BaseController{



	/*for displaying boards*/
	public function posta_boards_viewer($req,$res,$args){
		$this->view($res,'posta_boards/index.php', $args);
	}

	

	//for io buses 
	public function get_io_buses($req,$res,$args){
		$db_res = DB::table('io')
				->join('io_buses','io.io_transport_id','=','io_buses.id')
				->select('io.id as io_id','io.from as io_from','io.to as io_to','io_buses.carrier','io_buses.eta','io_buses.etd','io_buses.from','io_buses.to')
				->orderBy('io.date_updated', 'DESC')
				->get();
		$data = [
			"msg_data" => $db_res,
			"msg_status" => "OK"
		];
		return $res->withJSON($data,200);
	}


	/*
	* ARRIVALS (buses,flights,trains,ships)
	*/
	public function get_arrival_buses($req,$res,$args){
		/*$db_res = DB::table('io_arrivals as io')
				->join('centers_has_bus_carriers as chb','io.io_transport_id','=','chb.bus_carrier_id')
				->select('io.id as io_id','io.from as io_from','chb.name as carrier','chb.time_arrival as eta','io.current_status as status')
				->where('io.code_center_to','=',$args['center_code'])//
				->where('io.rec_department_id','=',$args['dep_id'])//
				->where('chb.center_id','=',$args['center_id'])//
				->where('io.date_exp_arrival','>=',$args['start_date'])//
				->where('io.date_exp_arrival','<=',$args['end_date'])//
				->orderBy('io.date_updated', 'DESC')
				->get();*/
		$center_code = $args['center_code'];
		$center_id = $args['center_id'];
		$rec_department_id = $args['dep_id'];
		$start_date = $args['start_date'];
		$end_date = $args['end_date'];

		$q = "SELECT io.id as io_id,io.from as io_from,io.current_status AS status,chb.name AS carrier,chb.time_arrival as eta
			  FROM io_arrivals AS io,centers_has_bus_carriers AS chb,bus_carriers bc
			  WHERE (io.io_transport_id = bc.id AND bc.id = chb.bus_carrier_id)
			  AND (io.code_center_to = '$center_code' AND io.rec_department_id = $rec_department_id AND io.date_exp_arrival>='$start_date' AND
			  io.date_exp_arrival<='$end_date' AND chb.center_id=$center_id)
			  ORDER BY io.date_updated DESC";

		$db_res = DB::select($q);
		$data = [
			"msg_data" => $db_res,
			"msg_status" => "OK"
		];
		return $res->withJSON($data,200);
	}
	public function get_arrival_flights($req,$res,$args){
		$db_res = DB::table('io_arrivals as io')
				->join('centers_has_flights as chf','io.io_transport_id','=','chf.flight_carrier_id')
				->select('io.id as io_id','io.from as io_from','chf.name as carrier','chf.time_arrival as eta','io.current_status as status')
				->where('io.code_center_to','=',$args['center_code'])//
				->where('io.rec_department_id','=',$args['dep_id'])//
				->where('chf.center_id','=',$args['center_id'])//
				->where('io.date_exp_arrival','>=',$args['start_date'])//
				->where('io.date_exp_arrival','<=',$args['end_date'])//
				->orderBy('io.date_updated', 'DESC')
				->get();
		$data = [
			"msg_data" => $db_res,
			"msg_status" => "OK"
		];
		return $res->withJSON($data,200);
	}
	public function get_arrival_trains($req,$res,$args){
		$db_res = DB::table('io_arrivals as io')
				->join('centers_has_train_carriers as cht','io.io_transport_id','=','cht.train_carrier_id')
				->select('io.id as io_id','io.from as io_from','cht.name as carrier','cht.time_arrival as eta','io.current_status as status')
				->where('io.code_center_to','=',$args['center_code'])//
				->where('io.rec_department_id','=',$args['dep_id'])//
				->where('cht.center_id','=',$args['center_id'])//
				->where('io.date_exp_arrival','>=',$args['start_date'])//
				->where('io.date_exp_arrival','<=',$args['end_date'])//
				->orderBy('io.date_updated', 'DESC')
				->get();
		$data = [
			"msg_data" => $db_res,
			"msg_status" => "OK"
		];
		return $res->withJSON($data,200);
	}
	public function get_arrival_ships($req,$res,$args){
		$db_res = DB::table('io_arrivals as io')
				->join('centers_has_ships as chs','io.io_transport_id','=','chs.ship_carrier_id')
				->select('io.id as io_id','io.from as io_from','chs.name as carrier','chs.time_arrival as eta','io.current_status as status')
				->where('io.code_center_to','=',$args['center_code'])//
				->where('io.rec_department_id','=',$args['dep_id'])//
				->where('chs.center_id','=',$args['center_id'])//
				->where('io.date_exp_arrival','>=',$args['start_date'])//
				->where('io.date_exp_arrival','<=',$args['end_date'])//
				->orderBy('io.date_updated', 'DESC')
				->get();
		$data = [
			"msg_data" => $db_res,
			"msg_status" => "OK"
		];
		return $res->withJSON($data,200);
	}





	/*
	* DEPARTURES (buses,flights,trains,ships)
	*/
	public function get_departure_buses($req,$res,$args){
		$db_res = DB::table('io_departures as io')
				->join('centers_has_bus_carriers as chb','io.io_transport_id','=','chb.bus_carrier_id')
				->select('io.id as io_id','io.to as io_to','chb.name as carrier','chb.time_departure as etd','io.current_status as status')
				->where('io.code_center_from','=',$args['center_code'])
				->where('io.rec_department_id','=',$args['dep_id'])//
				->where('chb.center_id','=',$args['center_id'])
				->where('io.date_exp_departure','>=',$args['start_date'])//
				->where('io.date_exp_departure','<=',$args['end_date'])//
				->orderBy('io.date_updated', 'DESC')
				->get();
		$data = [
			"msg_data" => $db_res,
			"msg_status" => "OK"
		];
		return $res->withJSON($data,200);
	}
	public function get_departure_flights($req,$res,$args){
		$db_res = DB::table('io_departures as io')
				->join('centers_has_flights as chf','io.io_transport_id','=','chf.flight_carrier_id')
				->select('io.id as io_id','io.to as io_to','chf.name as carrier','chf.time_departure as etd','io.current_status as status')
				->where('io.code_center_from','=',$args['center_code'])
				->where('io.rec_department_id','=',$args['dep_id'])//
				->where('chf.center_id','=',$args['center_id'])
				->where('io.date_exp_departure','>=',$args['start_date'])//
				->where('io.date_exp_departure','<=',$args['end_date'])//
				->orderBy('io.date_updated', 'DESC')
				->get();
		$data = [
			"msg_data" => $db_res,
			"msg_status" => "OK"
		];
		return $res->withJSON($data,200);
	}
	public function get_departure_trains($req,$res,$args){
		$db_res = DB::table('io_departures as io')
				->join('centers_has_train_carriers as cht','io.io_transport_id','=','cht.train_carrier_id')
				->select('io.id as io_id','io.to as io_to','cht.name as carrier','cht.time_departure as etd','io.current_status as status')
				->where('io.code_center_from','=',$args['center_code'])
				->where('io.rec_department_id','=',$args['dep_id'])//
				->where('cht.center_id','=',$args['center_id'])
				->where('io.date_exp_departure','>=',$args['start_date'])//
				->where('io.date_exp_departure','<=',$args['end_date'])//
				->orderBy('io.date_updated', 'DESC')
				->get();
		$data = [
			"msg_data" => $db_res,
			"msg_status" => "OK"
		];
		return $res->withJSON($data,200);
	}
	public function get_departure_ships($req,$res,$args){
		$db_res = DB::table('io_departures as io')
				->join('centers_has_ships as chs','io.io_transport_id','=','chs.ship_carrier_id')
				->select('io.id as io_id','io.to as io_to','chs.name as carrier','chs.time_departure as etd','io.current_status as status')
				->where('io.code_center_from','=',$args['center_code'])
				->where('io.rec_department_id','=',$args['dep_id'])//
				->where('chs.center_id','=',$args['center_id'])
				->where('io.date_exp_departure','>=',$args['start_date'])//
				->where('io.date_exp_departure','<=',$args['end_date'])//
				->orderBy('io.date_updated', 'DESC')
				->get();
		$data = [
			"msg_data" => $db_res,
			"msg_status" => "OK"
		];
		return $res->withJSON($data,200);
	}


















}