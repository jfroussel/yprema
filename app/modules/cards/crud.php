<?php
namespace App\Modules\Cards;

use RedCat\Strategy\Di;
use App\Route\Route;
use App\Route\User;
use RedCat\Route\Url;
use RedCat\Route\Request;
use App\Model\Db;

use RedCat\Strategy\CallTrait;

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
		dd($data);
		return $this->db->simpleEntity('card',$data)->store();
	}
	
	function load($id){
		$card = $this->db['card'][$id];
		$driver = $this->db['driver'][$card->driver_id];
		$card['driver_label'] = implode(' ',[$driver->prenom,$driver->nom,$driver->email]);
		return [
            'card' =>$card,
		];
	}
	
	function checkBarcode($params){
		list($barcode,$compare) = explode(',',$params);
		if(!$barcode) return true;
		$id = $this->db['card']->unSelect()->select('id')->where('barcode = ?',[$barcode])->getCell();
		return (!$id)||($compare&&$id==$compare);
	}
	
	function select2Driver($term){
		//$this->db->debug();
		$q = $this->db['driver']->unSelect()->select('id, nom, prenom, email');
		$q->openWhereOr();
		$q
			->likeBoth('nom',$term)
			->likeBoth('prenom',$term)
			->likeBoth('email',$term)
		;
		$q->closeWhere();
		$q->limit(10);
		$rows = $q->getAll();
		$r = [];
		foreach($rows as $row){
			$label = implode(' ',[$row->prenom,$row->nom,$row->email]);
			$r[] = [
				'id'=>$row->id,
				'text'=>$label,
			];
		}
		return $r;
	}
	
}
