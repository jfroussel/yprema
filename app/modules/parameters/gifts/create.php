<?php
namespace App\Modules\Parameters\Gift;

use App\AbstractController;

class Create extends AbstractController{
	protected $needAuth = true;
	
	function store($data){
		return $this->db['gift']->simpleEntity($data)->store();
	}
		
}
