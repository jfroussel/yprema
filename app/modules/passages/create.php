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
		$barcode = $data['barcode'];
		if(!$barcode) return;
		
		$driver = $this->getDriverByBarcode($barcode);
		
		if(!$driver) return;
		
		$this->db['passage']->simpleEntity($data)->store();
        
        return [
			'solde_base'=>$driver->getSoldeBase() ? : '0',
		];
    }
	
	protected function getDriverByBarcode($barcode){
		$row = $this->db->getRow('SELECT driver.*,card.statut FROM driver,card WHERE card.barcode = ? AND card.driver_id = driver.id', [$barcode]);
		if($row){
			$row = $this->db->simpleEntity('driver',$row);
		}
        return $row;
	}
    function getChauffeurInfo($barcode){
        $driver = $this->getDriverByBarcode($barcode);
        if(!$driver) return;
        return [
			'driver'=>$driver,
			'solde_base'=>$driver->getSoldeBase() ? : '0',
		];
    }


}
