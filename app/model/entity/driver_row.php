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
	protected $_barcodeNew;
	
	function getDynamic(){
        $this->dynamic->barcode = $this->getBarcode();
		
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

	function getBarcode(){
		return $this->card_id?$this->db['card'][$this->card_id]->barcode:null;
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
			$card = $this->db['card']->where('barcode = ?',[$this->_barcode])->getRow();
			if($card){
				if($card->driver_id&&$card->driver_id!=$this->id){
					throw new ValidationException("Un chauffeur est déjà enregistré avec ce code barre");
				}
			}
			else{
				$card = $this->makeNewCard();
				$this->_barcodeNew = true;
			}
			$this->card_id = $card->id;
		}
		
		if(isset($this->statut)){
			$this->statut = $this->statut?1:0;
		}
    }
    function beforeRecursive(){}
    function beforeCreate(){
		$this->date_creation = date('Y-m-d');
		$this->site_creation = $this->db['user'][$this->_user->id]->site;
    }

    function beforeRead(){


    }
    function beforeUpdate(){
		
    }
    function beforeDelete(){}
    function afterPut(){}
    function afterCreate(){
		if($this->_barcodeNew){
			$card = $this->db['card'][$this->card_id];
			$card->driver_id = $this->id;
			$card->store();
		}
	}
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
