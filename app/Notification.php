<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{

    protected $fillable = [
        'type', 'read'
    ];
    public function user(){
        return $this->belongsTo('App\User', 'foreign_key');
    }
    public function event(){
        return $this->hasManyThrough( 'App\Event','App\Notification');
    }

    public function markAsRead(){
        $this->read = TRUE;
        $this->update();
    }

    public function createNotification($type, $user_id, $event_id){
        $this->type = $type;
        $this->read = FALSE;
        $user = $user_id;
        $event = $event_id;
        $this->event_id = $event;
        $this->user_id = $user;
        $this->save();

    }

     static function createMassive($event){
       $participations = $event->participations;
       foreach ($participations as $participation) {
           $notification = new Notification;
           $notification->createNotification('evaluation', $participation->user_id, $event->id);
       }
    }

}
