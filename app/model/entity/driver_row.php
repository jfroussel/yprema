<?php
namespace App\Model\Entity;
use App\Model\EntityModel;
use App\Modules\Drivers;
//use App\Drivers;
use App\Model\NormalizeTrait;
class Driver_Row extends EntityModel{
	use NormalizeTrait;
	protected $validateProperties = [
        'id',
        'id_driver',
        'solde_base',
        'solde_bonus',
        'ctime',
        'statut',
        'mtime',
        'site_creation'


	];
	protected $validateFilters = [
		
	];
	
	function getDynamic(){
        $this->dynamic->barcode = $this->db['card']
			->unSelect()
			->select('barcode')
			->where('driver_id = ?',[$this->id])
			->getCell();
        
        return (array)$this->dynamic;
    }

	
	
    function beforePut(){
		
    }
    function beforeRecursive(){}
    function beforeCreate(){

    }

    function beforeRead(){


    }
    function beforeUpdate(){

    }
    function beforeDelete(){}
    function afterPut(){}
    function afterCreate(){}
    function afterRead(){}
    function afterUpdate(){}
    function afterDelete(){}
    function afterRecursive(){}






}
