<?php

namespace App\Modules\Drivers;

use DateTime;
use App\AbstractController;


class All extends AbstractController{
	protected $needAuth = true;

    function load(){
        return [

        ];
    }

    protected function formatCurrency($number){
        return money_format('%#1n', $number );
    }
}
