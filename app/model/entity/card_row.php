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
        'solde_total',
        'statut',
        'site_creation',
    ];


    function beforePut(){
		
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
		if(isset($this->statut)){
			$this->statut = $this->statut?1:0;
		}
	}
    function afterCreate(){}
    function afterRead(){

    }
    function afterUpdate(){}
    function afterDelete(){}
    function afterRecursive(){}

}
