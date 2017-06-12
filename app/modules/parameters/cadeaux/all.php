<?php
namespace App\Modules\Parameters\Cadeaux;

use App\AbstractController;

class All extends AbstractController{
	protected $needAuth = true;
	
	function delete($id){
		unset($this->db['cadeaux'][$id]);
	}
}
