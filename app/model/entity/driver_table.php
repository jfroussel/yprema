<?php
namespace App\Model\Entity;
use App\Model\TableModel;

class Driver_Table extends TableModel{
	protected $uniqColumns = ['email'];
	
	function checkEmailExists($email){
		return (!trim($email))?false:$this->db['driver']->unSelect()->select('id')->where('email = ?',[trim($email)])->getCell();
	}
	function checkFullNameExists($nom,$prenom){
		return !(trim($nom)&&trim($prenom))?false:$this->db['driver']->unSelect()->select('id')->where('nom = ? AND prenom = ?',[$nom,$prenom])->getCell();
	}
}
