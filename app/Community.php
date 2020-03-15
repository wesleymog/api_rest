<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Community extends Model
{
    protected $fillable = [
        'name', 'description','img'
    ];
    public function users(){
        return $this->belongsToMany(User::class);
    }

    public function admin(){
        return $this->belongsToMany(User::class)->where('is_admin', true);
    }

    public function contents(){
        return $this->belongsToMany(Content::class);
    }

    public function events(){
        return $this->belongsToMany(Event::class);
    }

    public function userIn(){
        if (DB::table('community_user')
        ->whereUserId(Auth::id())
        ->whereCommunityId($this->id)
        ->count() > 0) {
            $this->participation = true;
        } else {
            $this->participation = false;
        }

    }

    public function createCommunity($request){

            $admin = Auth::id();
            $this->name = $request->name;
            $this->description = $request->description;
            $this->img = $request->img;

            $this->save();

            $this->users()->attach([$this->id => ['is_admin' => true]]);

            return $this;

    }



    public function updateCommunity($request){
        $this->name = $request->name;
        $this->description = $request->description;
        $this->img = $request->img;

        $this->update();

        return $this;
    }

    public function subscribeUser($request){
        $user = User::find($request->user_id);
        $this->users()->attach($user, ['is_admin' => $request->is_admin]);
    }

    public function subscribeEvent($request){
        $event = Event::find($request->event_id);

        $this->events()->attach($event);
    }

    public function subscribeContent($request){
        $content = Content::find($request->content_id);
        $this->contents()->attach($content);
    }
}
