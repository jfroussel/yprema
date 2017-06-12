<?php
namespace App\Modules\Debtors;

use App\AbstractController;
use DateTime;

class Update extends AbstractController{
	protected $needAuth = true;
	
	function load($id){	
		$data = $this->db['debtor'][$id]->getArray();
		$data += [

            'user' =>$this->db['user'][$this->user->id],
		];
        //ddj($data);
		return $data;
	}

}
