<?php
namespace App\Model\Entity;
use App\Model\EntityModel;
use App\Model\ValidationException;

class Delivery_Row extends EntityModel{

    protected $validateProperties = [
        'id',
        'site',
        'gift_id',
        'barcode',
        'ctime',
        'card_id',
        'driver_id',
        'points',
    ];

    function beforePut(){ }
    function beforeRecursive(){}
    function beforeCreate(){
        $this->ctime = $this->now();
        $this->site = $this->db['user'][$this->_user->id]->site;
        $this->user_id = $this->_user->id;
        
        $card = $this->db['card']->where('barcode = ?',[$this->barcode])->getRow();
        
        $this->card_id = $card->id;
        $this->driver_id = $card->driver_id;
        
        if(!$this->gift_id){
			throw new ValidationException('Cadeau non spécifié');
		}
        
        $gift = $this->db['gift'][$this->gift_id];
        
        $this->points = $gift->nb_points;
        $card->solde_base = (int)$card->solde_base - (int)$gift->nb_points;
        $card->store();
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
