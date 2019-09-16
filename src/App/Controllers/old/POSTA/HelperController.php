<?php
namespace App\Controllers\POSTA;

class HelperController{

	public function help(){
		return "helpline zone";
	}


	/*
	* retrieving the custom ->with in arrival or departure from the given io-mod
	*/
	public function get_io_with_connector_for_arrival_departure_from_io_mode($opt){
		switch ($opt) {
			case 'LAND-BUSES': return "bus";break;
			case 'BUSES': return "bus";break;
			case 'LAND-TRAINS': return "train";break;
			case 'AIR': return "flight";break;
			case 'FLIGHTS': return "flight";break;
			case 'AIRLINES': return "flight";break;
			case 'PLANES': return "flight";break;
			case 'BOATS': return "ship";break;
			case 'SHIPS': return "ship";break;
			case 'MARINES': return "ship";break;
			case 'TRAINS': return "train";break;
			default: return "bus";break;
		}
	}


}

?>