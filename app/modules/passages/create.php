<?php
namespace App\Modules\Passages;
use App\AbstractController;
use App\Model\Entity\Passage_Table;
use DateTime;
use DateInterval;



class Create extends AbstractController{
	protected $needAuth = true;
   
    function load(){

        $article = $this->db['article'];
        $site = $this->db['site'];
		$data = [
            'articles' => $article,
            'sites' => $site,
		];
        //ddj($data);
		return $data;
	}

    function store($data){
        return $this->db['passage']->simpleEntity($data)->store();
    }

    function getChauffeurInfo($data){
        $rq = $this->db->getRow('SELECT driver.* FROM driver,card WHERE card.barcode = ? AND card.driver_id = driver.id', [$data]);
        return $rq;
    }


}
