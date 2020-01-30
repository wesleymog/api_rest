<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Invitation extends Model
{
    protected $fillable = [
        'event_id', 'receiver_id', 'sender_id',
    ];

    public function makeInvitation($request){
        $this->receiver_id = $request->receiver_id;
        $this->sender_id = Auth::id();
        $this->event_id = $request->event_id;

        $this->save();
    }

    public function receiver(){
        return $this->belongsTo('App\User', 'receiver_id');
    }
    public function sender(){
        return $this->belongsTo('App\User', 'sender_id');
    }

}
