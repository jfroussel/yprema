<?php

namespace App\Modules\Promise;

use RedCat\Route\Request;
use FoxORM\MainDb as Db;

use App\AbstractController;

class Add extends AbstractController{

    function __invoke(Request $request, Db $db){

        if($request->posted&&!$request->amount){
			$data['state'] = 'ok';
			return $data;
		}
		
        $token = $request->token;


        $data =  [
			'state'=>null,
			'token'=>$token,

		];

        if($token){
			$row = $db['promise_token']->where('token=?', [$token])->getRow();
		}

        if(!($token&&$row)){
			$data['error'] = 'invalid or allready used token';
			$data['state'] = 'error';
			return $data;
		}

        $driver_id = $row->driver_id;
        $driver = $db['driver'][$driver_id];
        $data['logo'] = '../content/user/avatar.png';

        $cards = $db['card']->reporting($driver->primary);
        $data['cards'] = $cards;


        
        $cards_id = [];
        foreach($cards as $id=>$card){
			$cards_id[] = $id;
		}
        
        if($request->amount){
			
			$posted_cards = array_filter($request->card->getArray(),function($id)use($cards_id){
				return in_array($id,$cards_id);
			});

            $db['promise'][] = [
				'driver_id' => $driver_id,
                'amount' => $request->amount,
                'date_reglement' =>$request->date_reglement,
                'payment_type' =>$request->payment_type,
                '_xmany2many_card'=>$posted_cards,
            ];

            $row->delete();
            
            $data['state'] = 'ok';
        }

        return $data;
    }

}
