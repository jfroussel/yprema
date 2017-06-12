<?php
namespace App\Modules\Home;
use App\AbstractController;
use App\Model\Entity\Passage_Table;
use DateTime;
use DateInterval;



class TabHome extends AbstractController{
	protected $needAuth = true;
   
    function load(){

        $debtor = $this->db['user'][$this->user->instance_id];
        $article = $this->db['article'];
        $site = $this->db['site'];
		$data = [
			'user' => $debtor,
            'articles' => $article,
            'sites' => $site,
		];
		//ddj($data);
		return $data;
	}

    function store($data){
        return $this->db['passage']->simpleEntity($data)->store();
    }


}
