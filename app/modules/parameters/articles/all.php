<?php
namespace App\Modules\Parameters\Articles;

use App\AbstractController;

class All extends AbstractController{
	protected $needAuth = true;
	
	function delete($id){
		unset($this->db['articles'][$id]);
	}
}
