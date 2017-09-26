<?php
namespace App\Model;
trait HistorizeTrait{
    function historize(){
        $history = $this->db['history'];
        $action = $history->entity([
            'category'=>$this->category,
            '_one_'.$this->_type=>$this->id,
            'table'=>$this->_type,
            'message'=>$this->message,
            '_one_user'=>$this->_one_user,
            'driver_primary'=>$this->driver_primary,
            'driver_id'=>$this->driver_id,
            'job_primary' =>$this->job_primary,
            'job_url' => $this->job_url,
            'type' => $this->type,
            'timer' =>$this->timer,
        ]);

        $history[] = $action;
    }
}
