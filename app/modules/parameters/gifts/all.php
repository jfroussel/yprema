<?php
namespace App\Modules\Parameters\Gift;

use App\AbstractController;

class All extends AbstractController{
	protected $needAuth = true;
	
	function delete($id){
		unset($this->db['gift'][$id]);
	}
}
