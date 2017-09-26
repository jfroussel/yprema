<?php
namespace App\Modules\Home;
use App\AbstractController;
use App\Model\Entity\Passage_Table;
use DateTime;
use DateInterval;



class TabHome extends AbstractController{
	protected $needAuth = true;
   
    function load(){

        $article = $this->db['article'];
        $site = $this->db['site'];
		$data = [
            'user'=>$this->db['user'][$this->user->id],
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
        $rq = $this->db['driver']->where('barcode = ?', [$data])->getRow();
        return $rq;
    }


}
