<?php
namespace App\Modules\Parameters\Articles;

use App\AbstractController;

class Create extends AbstractController{
	protected $needAuth = true;
	
	function store($data){
		return $this->db['articles']->simpleEntity($data)->store();
	}
		
}
