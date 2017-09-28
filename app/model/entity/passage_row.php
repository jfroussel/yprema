<?php
namespace App\Model\Entity;
use App\Model\EntityModel;
class Passage_Row extends EntityModel{

    protected $validateProperties = [
        'id',
        'site',
        'nom',
        'prenom',
        'entreprise',
        'article',
        'barcode',
        'ctime'
    ];

    function beforePut(){ }
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
