<?php
namespace App\Modules\Drivers;

use App\AbstractController;
use DateTime;

class Update extends AbstractController{
	protected $needAuth = true;
	
	function load($id){	
		return [
            'driver' =>$this->db['driver'][$id],
		];
	}

}
