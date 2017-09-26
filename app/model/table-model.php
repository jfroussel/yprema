<?php
namespace App\Model;
use FoxORM\Entity\TableWrapperSQL;
use FoxORM\DataSource;
use FoxORM\DataTable;
use App\Route\User;
use RedCat\Strategy\Di;

class TableModel extends TableWrapperSQL{
	protected $user;
	protected $_di;
	function __construct($type, DataSource $db=null, DataTable $table=null,User $user, Di $di){
		parent::__construct($type, $db, $table);
		$this->user = PHP_SAPI!='cli'?$user:false;
		$this->_di = $di;
	}
	
}
