<?php
namespace App\Modules\Parameters\Cadeaux;

use App\AbstractController;

class Create extends AbstractController{
	protected $needAuth = true;
	
	function store($data){
		return $this->db['cadeaux']->simpleEntity($data)->store();
	}
		
}
