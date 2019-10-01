<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Participation extends Model
{
    protected $fillable = [
        'status', 'event_id', 'user_id','rate', 'confirm_status', 'interest_status',
    ];    
    public $timestamps = false;

    public function confirmParticipation(){
        $this->confirm_status = TRUE;
        $this->save;
    }
    public function interestParticipation(){
        $this->interest_status = TRUE;
        $this->save;    
    }
    public function rateParticipation($request){
        $this->status = $request->status;
        $this->rate = $request->rate;
        $this->save;
        
    }

    public function createParticipation($request){

        $user = $request->user_id;
        $event = $request->event_id;
        $this->status = $request->status;
        $this->event_id = $event;
        $this->user_id = $user;
        $this->rate = $request->rate;
        $this->confirm_status = $request->confirm_status;
        $this->interest_status = $request->interest_status;
        
        $this->save();
    }

    public function updateParticipation($request){
        
        $this->rate = $request->rate;
        if($request->confirm_status == 0 || $request->confirm_status == 1){
            $this->confirm_status = $request->confirm_status;
        }
        if($request->interest_status){
            $this->interest_status = $request->interest_status;
        }
        $this->status = $request->status;
        $this->save();
    }
    
}
