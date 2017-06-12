<?php
namespace App\Modules\Parameters\Sites;

use App\AbstractController;

class Update extends AbstractController{
	protected $needAuth = true;
	
	function load($id){
		return [
			'sites' => $this->db['sites'][$id]
		];
	}
	function store($data){
		if(!isset($data['id'])) return;
		return $this->db['sites']->simpleEntity($data)->store();
	}
	
}
