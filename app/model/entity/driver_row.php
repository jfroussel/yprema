<?php
namespace App\Model\Entity;
use App\Model\EntityModel;
use App\Modules\Drivers;
//use App\Drivers;
use App\Model\NormalizeTrait;

use App\Model\ValidationException;

class Driver_Row extends EntityModel{
	use NormalizeTrait;
	protected $validateProperties = [
        'id',
		'email',
		'nom',
		'prenom',
        'civ',
		'portable',
		'entreprise',
		'adresse',
		'code_postal',
		'ville',
        'card_id',
        'statut',
        'site_creation',

	];
	protected $validateFilters = [
		
	];
	
	protected $_barcode;
	
	function getDynamic(){
        $this->dynamic->barcode = $this->db['card']
			->unSelect()
			->select('barcode')
			->where('driver_id = ?',[$this->id])
			->getCell();
		
		$this->dynamic->solde_base = $this->db['card']
			->unSelect()
			->select('SUM(solde_base)')
			->where('driver_id = ?',[$this->id])
			->getCell();
        
        $this->dynamic->solde_bonus = $this->db['card']
			->unSelect()
			->select('SUM(solde_bonus)')
			->where('driver_id = ?',[$this->id])
			->getCell();
        
        $this->dynamic->card_statut = $this->db['card']
			->unSelect()
			->select('statut')
			->where('id = ?',[$this->card_id])
			->getCell();
        
        return (array)$this->dynamic;
    }

	
	
    function beforeValidate(){
		if(isset($this->barcode)){
			$this->_barcode = $this->barcode;
		}
	}
    function beforePut(){
		if(!trim($this->email)){
			throw new ValidationException("le champs email est dorénavant obligatoire");
		}
		
		$table = $this->db['driver'];
		
		if(isset($this->email)){
			$id = $table->checkEmailExists($this->email);
			if($id&&$id!=$this->id){
				throw new ValidationException("Un chauffeur est déjà enregistré avec cet email");
			}
		}
		
		if($this->_barcode){
			$id = $table->checkBarcodeExists($this->_barcode);
			if($id&&$id!=$this->id){
				throw new ValidationException("Un chauffeur est déjà enregistré avec ce code barre");
			}
			if(!$id){
				$this->makeNewCard();
			}
		}
		
		if(isset($this->statut)){
			$this->statut = $this->statut?1:0;
		}
    }
    function beforeRecursive(){}
    function beforeCreate(){
    }

    function beforeRead(){


    }
    function beforeUpdate(){
		
    }
    function beforeDelete(){}
    function afterPut(){}
    function afterCreate(){}
    function afterRead(){}
    function afterUpdate(){}
    function afterDelete(){}
    function afterRecursive(){}
	
	
	function makeNewCard(){
		$card = $this->db->simpleEntity('card',[
			'driver_id'=>$this->id,
			'barcode'=>$this->_barcode,
			'site_creation'=>$this->db['user'][$this->_user->id]->site,
		]);
		$card->store();
		return $card;
	}



}
