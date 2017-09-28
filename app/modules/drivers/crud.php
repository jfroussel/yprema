<?php
namespace App\Modules\Drivers;

use RedCat\Strategy\Di;
use DateTime;
use App\Route\Route;
use App\Route\User;
use RedCat\Route\Url;
use RedCat\Route\Request;
use App\Model\Db;

use RedCat\Strategy\CallTrait;
use RedCat\FileIO\Uploader;

use App\AbstractController;

class Crud extends AbstractController{
	
	protected $needAuth = true;
	
	protected $table;

	function __construct(Db $db, Route $route, Di $di, User $user, Request $request){
		$this->di = $di;
		$this->db = $db;
		$this->request = $request;
		$this->user = $user;
	}
	function store($data, Url $url){
		if(!isset($data['id'])){
			$data['user_id'] = $this->user->id;
		}
		$driver = $this->db->simpleEntity('driver',$data);
		return $driver->store();
	}
	function checkEmail($params){
		list($email,$compare) = explode(',',$params);
		$id = $this->db['driver']->checkEmailExists($email);
		return (!$id)||($compare&&$id==$compare);
	}
	
	function checkEmailExists($email){
		return $this->db['driver']->checkEmailExists($email);
	}
	
	function checkBarcode($params){
		list($barcode,$compare) = explode(',',$params);
		$id = $this->db['driver']->checkBarcodeExists($barcode);
		return (!$id)||($compare&&$id==$compare);
	}
	
	function checkBarcodeExists($barcode){
		return $this->db['driver']->checkBarcodeExists($barcode);
	}
	
	function checkFullNameExists($nom,$prenom){
		return $this->db['driver']->checkFullNameExists($nom,$prenom);
	}
	
	function storeStatut($data){
		$id = $data['id'];
		$driver = $this->db['driver'][$id];
		$card_id = $driver->card_id;
		if(!$card_id) return;
		$card = $this->db['card'][$card_id];
		$card->statut = $data['card_statut']=='1'?1:0;
		return $card->store();
	}
	
	function load($id){	
		return [
            'driver' =>$this->db['driver'][$id],
		];
	}

	
}
