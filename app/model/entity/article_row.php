<?php
namespace App\Model\Entity;
use App\Model\EntityModel;
class Article_Row extends EntityModel{
    protected $validateProperties = [
		'code',
		'designation',
		'mouvement',
		'points',
    ];

    function beforePut(){
		if(isset($this->points)){
			$this->points = (int)$this->points;
		}
	}
    function beforeRecursive(){}
    function beforeCreate(){
        $this->ctime = $this->now();
    }
    function beforeRead(){}
    function beforeUpdate(){
        $this->mtime = $this->now();
    }
    function beforeDelete(){}
    function afterPut(){}
    function afterCreate(){

    }
    function afterRead(){}
    function afterUpdate(){}
    function afterDelete(){}
    function afterRecursive(){}

}
