<?php
namespace App\Model\Entity;
use App\Model\EntityModel;
use App\Model\NormalizeTrait;
use App\Model\HistorizeTrait;
class Contact_Row extends EntityModel{
    use HistorizeTrait;
    use NormalizeTrait;
    
    protected $validateProperties = [
        'id',
        'driver_id',
        'nom',
        'prenom',
        'role',
        'fonction',
        'principal',
        'address',
        'postal_code',
        'city',
        'country',
        'email',
        'tel',
        'fax',
        'portable',
        'type',
        'comment',
        'active',
        'ctime',
        'import_timestamp'
    ];
    
    function beforePut(){
		$this->normalizeDateFields();
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
        //$this->historize();
    }
    function afterRead(){}
    function afterUpdate(){}
    function afterDelete(){}
    function afterRecursive(){}

}
