<?php
namespace App\Modules;
use RedCat\Framework\FrontController\RenderInterface;
use App\AbstractController;
use App\Templix\Templix;

class _ extends AbstractController implements RenderInterface{
	
	function __invoke(Templix $templix){
		$data = [];
		$templix->display('modules/saas.tml',$data);
	}
	
	function load(){
		$data = [];
		$data['user'] = $this->mainDb['user'][$this->user->id];
		return $data;
	}
	
}
