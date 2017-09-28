<?php
namespace App\Model\Entity;
use App\Model\EntityModel;
use App\Model\NormalizeTrait;
use DateTime;


class Card_Row extends EntityModel{
	use NormalizeTrait;

    protected $validateProperties = [
        'driver_id',
        'barcode',
        'solde_base',
        'solde_bonus',
        'statut',
        'site_creation',
    ];


    function beforePut(){
		if(isset($this->statut)){
			$this->statut = $this->statut?1:0;
		}
		if(isset($this->solde_base)){
			$this->solde_base = (int)$this->solde_base;
		}
		if(isset($this->solde_bonus)){
			$this->solde_bonus = (int)$this->solde_bonus;
		}
    }
    function beforeRecursive(){

    }
    function beforeCreate(){
    }

    function beforeRead(){

    }
    function beforeUpdate(){

    }
    function beforeDelete(){}
    function afterPut(){
	}
    function afterCreate(){}
    function afterRead(){

    }
    function afterUpdate(){}
    function afterDelete(){}
    function afterRecursive(){}

}
