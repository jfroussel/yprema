<?php
namespace App\Model\Entity;
use App\Model\EntityModel;
use App\Model\NormalizeTrait;
use DateTime;


class Card_Row extends EntityModel{
	use NormalizeTrait;

    protected $validateProperties = [
        'driver_id',
		//'',
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
    function afterPut(){}
    function afterCreate(){}
    function afterRead(){

    }
    function afterUpdate(){}
    function afterDelete(){}
    function afterRecursive(){}

}
