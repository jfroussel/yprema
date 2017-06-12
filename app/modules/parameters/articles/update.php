<?php
namespace App\Modules\Parameters\Articles;

use App\AbstractController;

class Update extends AbstractController{
	protected $needAuth = true;
	
	function load($id){
		return [
			'articles' => $this->db['articles'][$id]
		];
	}
	function store($data){
		if(!isset($data['id'])) return;
		return $this->db['articles']->simpleEntity($data)->store();
	}
	
}
