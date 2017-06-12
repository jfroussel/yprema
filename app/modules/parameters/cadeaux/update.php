<?php
namespace App\Modules\Parameters\Cadeaux;

use App\AbstractController;

class Update extends AbstractController{
	protected $needAuth = true;
	
	function load($id){
		return [
			'cadeaux' => $this->db['cadeaux'][$id]
		];
	}
	function store($data){
		if(!isset($data['id'])) return;
		return $this->db['cadeaux']->simpleEntity($data)->store();
	}
	
}
