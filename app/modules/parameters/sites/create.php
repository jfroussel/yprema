<?php
namespace App\Modules\Parameters\Sites;

use App\AbstractController;

class Create extends AbstractController{
	protected $needAuth = true;
	
	function store($data){
		return $this->db['sites']->simpleEntity($data)->store();
	}
		
}
