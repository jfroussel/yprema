<?php
namespace App\Model\Entity;
use App\Model\EntityModel;
class Gift_Row extends EntityModel{

    protected $validateProperties = [
		'description',
		'points',
		'code',
		'stock',
    ];

    function beforePut(){ }
    function beforeRecursive(){}
    function beforeCreate(){
        $this->ctime = $this->now();
    }
    function beforeRead(){}
    function beforeUpdate(){
		
		if(isset($this->points)){
			$this->points = (int)$this->points;
		}
		if(isset($this->stock)){
			$this->stock = (int)$this->stock;
		}
    }
    function beforeDelete(){}
    function afterPut(){}
    function afterCreate(){
        $this->historize();
    }
    function afterRead(){}
    function afterUpdate(){}
    function afterDelete(){}
    function afterRecursive(){}

}
