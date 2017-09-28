<?php
namespace App\Modules\Gifts;
use App\AbstractController;
use App\Model\Entity\Passage_Table;
use DateTime;
use DateInterval;



class Delivery extends AbstractController{
	protected $needAuth = true;
   
    function load(){

        $gifts = $this->db['gift'];
        $site = $this->db['site'];
		$data = [
			'gifts'=>$gifts,
		];
        //ddj($data);
		return $data;
	}

    function store($data){
		$barcode = $data['barcode'];
		if(!$barcode) return;
		
		$driver = $this->getDriverByBarcode($barcode);
		
		if(!$driver) return;
		
		$this->db['delivery']->simpleEntity($data)->store();
        
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
