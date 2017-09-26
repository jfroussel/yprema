<?php
namespace App\Modules\Cards;

use App\AbstractController;

class Update extends AbstractController{
	protected $needAuth = true;
    function load($id,$driver_id=null){
		$data = $this->db['card'][$id];
		if($driver_id){
			$driver = $this->db['driver'][$driver_id];
			$data['driver_id'] = $driver->id;
			$data['driver_nom_client'] = $driver->nom_client;
		}
		return $data;
	}
}
