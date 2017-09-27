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
	function checkEmail($email,$compare=null){
		$id = $this->db['driver']->checkEmailExists($email);
		return (!$id)||($compare&&$id==$compare);
	}
	
	function checkEmailExists($email){
		return $this->db['driver']->checkEmailExists($email);
	}
	function checkFullNameExists($nom,$prenom){
		return $this->db['driver']->checkFullNameExists($nom,$prenom);
	}
	
	function load($id){	
		return [
            'driver' =>$this->db['driver'][$id],
		];
	}

	
}
