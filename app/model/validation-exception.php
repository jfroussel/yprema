<?php
namespace App\Model;
class ValidationException extends \Exception implements \JsonSerializable{
	function jsonSerialize(){
		return ['error'=>$this->getMessage()];
	}
}
