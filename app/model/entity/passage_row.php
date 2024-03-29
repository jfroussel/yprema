<?php
namespace App\Model\Entity;
use App\Model\EntityModel;
use App\Model\ValidationException;

class Passage_Row extends EntityModel{

    protected $validateProperties = [
        'id',
        'site',
        'nom',
        'prenom',
        'entreprise',
        'article_id',
        'article_designation',
        'barcode',
        'ctime',
        'user_id',
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
        
        $driver = $this->db['driver'][$this->driver_id];
        
        if(!$this->article_id){
			throw new ValidationException('Matériau non spécifié');
		}
        
        $article = $this->db['article'][$this->article_id];
        $this->article_designation = $article->designation;
        
        $this->points = $article->points;
        $driver->points = (int)$driver->points + (int)$article->points;
        $driver->store();
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
