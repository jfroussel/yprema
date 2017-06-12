<?php
namespace App\Model\Entity;
use App\Model\EntityModel;
use App\Modules\Debtors;
//use App\Debtors;
use App\Model\NormalizeTrait;
class Debtor_Row extends EntityModel{
	use NormalizeTrait;
	protected $validateProperties = [
        'id',
        'id_chauffeur',
        'solde_base',
        'solde_bonus',
        'ctime',
        'statut',
        'mtime',
        'site_creation'


	];
	protected $validateFilters = [
		'use_interval'=>'bool',
	];
    function beforePut(){
		$this->normalizeDateFields();
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
