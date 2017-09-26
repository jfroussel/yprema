<?php
namespace App\Modules\Drivers;

use App\AbstractController;
use DateTime;

class Update extends AbstractController{
	protected $needAuth = true;
	
	function load($id){	
		$data = $this->db['driver'][$id]->getArray();
		$data += [

            'user' =>$this->db['user'][$this->user->id],
		];
        //ddj($data);
		return $data;
	}

}
