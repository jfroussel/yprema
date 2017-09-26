<?php
namespace App\Modules\Parameters\Gift;

use App\AbstractController;

class Update extends AbstractController{
	protected $needAuth = true;
	
	function load($id){
		return [
			'gift' => $this->db['gift'][$id]
		];
	}
	function store($data){
		if(!isset($data['id'])) return;
		return $this->db['gift']->simpleEntity($data)->store();
	}
	
}
