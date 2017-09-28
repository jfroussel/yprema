<?php
namespace App\Model\Entity;
use App\Model\EntityModel;
use App\Model\HistorizeTrait;
class Article_Row extends EntityModel{
    use HistorizeTrait;

    protected $validateProperties = [
		'code',
		'designation',
		'mouvement',
		'nb_points_basique',
    ];

    function beforePut(){
		if(isset($this->nb_points_basique)){
			$this->nb_points_basique = (int)$this->nb_points_basique;
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
        $this->historize();
    }
    function afterRead(){}
    function afterUpdate(){}
    function afterDelete(){}
    function afterRecursive(){}

}
