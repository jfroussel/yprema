<?php
namespace App\Modules\Gifts;

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
		return $this->db->simpleEntity('gift',$data)->store();
	}
	
	function load($id){	
		return [
            'gift' =>$this->db['gift'][$id],
		];
	}
	
	function checkBarcode($params){
		list($barcode,$compare) = explode(',',$params);
		if(!$barcode) return true;
		$id = $this->db['gift']->unSelect()->select('id')->where('barcode = ?',[$barcode])->getCell();
		return (!$id)||($compare&&$id==$compare);
	}
	
}
