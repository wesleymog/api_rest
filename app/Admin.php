<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Admin extends Model
{
    public function BestTagsInitiatives(){
        $tags = Tag::withCount('events')->orderBy('events_count', 'desc')->limit(10)->get();
        $indicators = $tags;
        return $indicators;
    }
    public function BestTagsUsers(){
        $user = Tag::withCount('users')->orderBy('users_count', 'desc')->limit(10)->get();
        $indicators = $user;
        return $indicators;
    }
    public function MostConfirmedInitiatives(){
        $events = Event::withCount('users_confirmed')->orderBy('users_confirmed_count', 'desc')->limit(10)->get();
        $indicators = $events;
        return $indicators;
    }

    public function CountEventsByMonth(){
        $now = new Carbon('now');
        $events = Event::whereMonth('start_time',$now->month)->get();
        $indicators = $events;
        return $indicators;
    }
}
