<?php
namespace App\Modules\Parameters\sites;

use App\AbstractController;

class All extends AbstractController{
	protected $needAuth = true;
	
	function delete($id){
		unset($this->db['sites'][$id]);
	}
}
