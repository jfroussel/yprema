<?php
namespace App\Modules\Articles;

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
		return $this->db->simpleEntity('article',$data)->store();
	}
	
	function load($id){	
		return [
            'article' =>$this->db['article'][$id],
		];
	}
	
}
