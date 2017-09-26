<?php
namespace App\Model\Entity;
use App\Model\TableModel;

class Driver_Table extends TableModel{
	protected $uniqColumns = ['primary', 'siret'];
	function getPrimary($id){
		return $this->unSelect()->select('`primary`')->where('id = ?',[$id])->getCell();
	}
	function getCurrentScenarioStep($id ){
        $running_scenario =  $this[$id]
			->_many_running_scenario
			->where('running_type = ?',['current'] )
			->getRow();
        if($running_scenario){
            return $running_scenario->_many_running_scenario_step;
        }
        return [];
       
    }
}
