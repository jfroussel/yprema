<?php
namespace App\Modules\Users;

use RedCat\Strategy\Di;
use DateTime;
use App\Route\Route;
use App\Route\User;
use RedCat\Route\Url;
use RedCat\Route\Request;
use App\Model\Db;
use App\Modules\Auth\Auth;
use RedCat\Identify\PHPMailer;
use RedCat\Route\SilentProcess;

use RedCat\Strategy\CallTrait;
use RedCat\FileIO\Uploader;

use App\AbstractController;

class Create extends AbstractController{
	
	protected $needAuth = true;
	
	protected $table;

	function __construct(Db $db, Route $route, Di $di, User $user, Request $request){
		$this->di = $di;
		$this->db = $db;
		$this->request = $request;
		$this->user = $user;
		$this->table = clone $this->db['user'];
		$this->table->where('user_id = ?',[$user->id]);
	}
	function store($user, Url $url, SilentProcess $silentProcess, Auth $auth){
		$driver = $this->db->simpleEntity('driver',$user);
		$driver->user_id = $this->user->id;
		$this->db['user'][] = $user;
		return $user->id?$user:false;
	}
	function checkEmail($email,$compare=null){
		if(!$this->table->exists()) return true;
		$id = $this->db['user']->select('id')->where('email = ?',[$email])->getCell();
		return (!$id)||($compare&&$id==$compare);
	}

	
}
