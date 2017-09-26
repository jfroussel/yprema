<?php
namespace App\Modules\Parameters;
use App\AbstractController;
use App\Model\Db;
use RedCat\FileIO\Helper;
use RedCat\FileIO\Uploader;
use RedCat\CSVTools\DelimiterFinder;
use App\Route\User;
use RedCat\Route\Request;

use App\Route\Route;
use RedCat\Strategy\Di;
use FoxORM\MainDb;

use ForceUTF8\Encoding;
use Redis;
class TabFileImport extends AbstractController{
	protected $needAuth = true;
	protected $importingDirPath = '.data/importing/';
	protected $columns = [
		'driver'=>[
            'id',
            'civ',
            'nom',
            'prenom',
            'portable',
            'entreprise',
            'adresse',
            'code_postal',
            'ville',
            'email',
            'flag_delete',
            'date_delete',
            'barcode',
            'solde_base',
            'solde_bonus',
            'site_creation',
            'statut',
            'date_creation'
		],
		'card'=>[
            'id',
            'id_driver',
            'solde_base',
            'solde_bonus',
            'solde_total',
            'statut',
            'ctime',
            'mtime',
            'site_creation'


		],
        'contact' =>[

        ]
	];
	protected $columnsKeys = [
		'driver'=>['primary'],
		'card'=>['primary','driver_primary'],
        'contact'=>['primary','driver_primary'],
	];
	protected $db;
	protected $user;
	function __construct(Db $db, Redis $redis, Di $di, Request $request, User $user, Route $route, MainDb $mainDb){
		parent::__construct($di, $db, $request, $user, $route, $mainDb);
		$this->db = $db;
		$this->user = $user;
		$this->redis = $redis;
	}
	function load(){
		$data = [];
		$data['columns'] = $this->columns;
		$data['maxfilesize'] = Helper::getMaxUploadSize();
		$data['userColumns'] = $this->getImportedColumns();
		$data['importmap'] = $this->getMappedColumns();
		$data['state'] = [
		    'driver'=>$this->checkState('driver'),
            'card'=>$this->checkState('card'),
            'contact'=>$this->checkState('contact')
        ];
		return $data;
	}
	protected function getCsvColumns($file){
		$csv = new DelimiterFinder($file);
		$separator = $csv->find();
		
		$fp = fopen($file,'r');		
		$line = fgetcsv($fp, 0, $separator);
		fclose($fp);
		$line = array_map([Encoding::class,'toUTF8'],$line);
		if(end($line)=='')
			array_pop($line);
		$columns = array_map('self::normalizeColumn',$line);
		$columns = array_map('strtolower',$columns);
		return $columns;
	}
	function getImportedColumns(){
		$data = [];
		$dir = sprintf($this->importingDirPath,$this->user->id);
		if(is_file($file=$dir.'driver.csv')){
			$data['driver'] = $this->getCsvColumns($file);
		}
		if(is_file($file=$dir.'card.csv')){
			$data['card'] = $this->getCsvColumns($file);
		}
        if(is_file($file=$dir.'contact.csv')){
            $data['contact'] = $this->getCsvColumns($file);
        }
		return $data;
	}
	function getMappedColumns(){
		$data = [];
		$map_import_driver = $this->db['map_import_driver'];
		$map_import_card = $this->db['map_import_card'];
        $map_import_contact = $this->db['map_import_contact'];
		if($map_import_driver->exists()){
			$data['driver'] = $map_import_driver->where('user_id = ?',[$this->user->id])->getRow();
		}
		if($map_import_card->exists()){
			$data['card'] = $map_import_card->where('user_id = ?',[$this->user->id])->getRow();
		}
        if($map_import_contact->exists()){
            $data['contact'] = $map_import_contact->where('user_id = ?',[$this->user->id])->getRow();
        }
		return $data;
	}
	function getRenewDataUpload(){
		$data = [];
		$data['userColumns'] = $this->getImportedColumns();
		$data['importmap'] = $this->getMappedColumns();
		return $data;
	}
	function upload(Request $request, Uploader $uploader){
		$dir = $this->importingDirPath;
		if(!in_array($request->type,['driver','card', 'contact']))
			return;
		if(!is_dir($dir)){
			mkdir($dir,0777,true);
		}
		$mime = null;
		$finalName = $dir.$request->type.'.csv';
		if(is_file($finalName)){
			unlink($finalName);
		}
		$callback = function($file)use($dir,$request,$finalName){
			rename($file,$finalName);
		};
		$uploader->file($dir,'file',$mime,$callback);
		return true;
	}
	protected function storeImportMapProcess($type,$data){
		$tableName = 'map_import_'.$type;
		$filter = $this->columns[$type];
		$columnsKeys = $this->columnsKeys[$type];
		foreach($columnsKeys as $c){
			$filter[] = $c;
		}
		$table = $this->db[$tableName];
		if($table->exists()){
			//$this->db->debug();
			$row = $table->where('user_id = ?',[$this->user->id])->getRow();
		}
		else{
			$row = false;
		}
		if(!$row){
			$row = $this->db->simpleEntity($tableName);
			$row->_one_user_x_ = $this->user->id;
		}
		$filtered = $row->import($data,$filter);
		$table[] = $row;
	}
	function storeImportMap($data){
		if(isset($data['driver'])){
			$this->storeImportMapProcess('driver',$data['driver']);
		}
		
		if(isset($data['card'])){
			$this->storeImportMapProcess('card',$data['card']);
		}
        if(isset($data['contact'])){
            $this->storeImportMapProcess('contact',$data['contact']);
        }
		return true;
	}
	static function normalizeColumn($string){
		return strtolower(trim(preg_replace('~[^0-9a-z]+~i', '_', html_entity_decode(preg_replace('~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i', '$1', htmlentities($string, ENT_QUOTES, 'UTF-8')), ENT_QUOTES, 'UTF-8')), '_'));
	}
	
	protected function checkExistInList($table,$key){
		if(!isset($this->columns[$table])) return;
		$user = $this->user->id;
		$waiting = $this->redis->lRange('my:tasks:'.$key,0,-1);
		$count = count($waiting);
		for($i=0;$i<$count;$i++){
			$task = json_decode($waiting[$i],true);
			if($task['key']=='import:user'){
				$metadata = $task['metadata'];
				if($metadata['user']==$user&&$metadata['table']==$table){
					return true;
				}
			}
		}
	}
	protected function checkExistInH($table,$key){
		if(!isset($this->columns[$table])) return;
		$user = $this->user->id;
		$waiting = $this->redis->hGetAll('my:tasks:'.$key);
		$nsPrefix = 'import:';
		$lnsPrefix = strlen($nsPrefix);
		foreach($waiting as $json){
			$task = json_decode($json,true);
			if(substr($task['key'],0,$lnsPrefix)==$nsPrefix){
				$metadata = $task['metadata'];
				if($metadata['user']==$user&&$metadata['table']==$table){
					return true;
				}
			}
		}
	}
	function checkQueued($table){
		return $this->checkExistInList($table,'waiting');
	}
	function checkRunning($table){
		return $this->checkExistInH($table,'unfinished');
	}
	function checkState($table){
		return $this->checkRunning($table)?'running':($this->checkQueued($table)?'queued':false);
	}
	function importManual($table){
		if(!isset($this->columns[$table])) return;
		$user = $this->user->id;
		
		$state = $this->checkState($table);
		if(!$state){
			exec("php artist my:import:addtask $user $table user");
			$state = 'queued';
		}
		
		return ['state'=>$state];
	}
	
	
}
