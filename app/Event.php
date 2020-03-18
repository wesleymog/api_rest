<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
class Event extends Model
{
	 protected $fillable = [
        'type','category', 'title', 'code','start_time'
        ,'end_time', 'location', 'description','img','value','user_id', 'boost'
    ];

    public function communities(){
        return $this->hasMany(Community::class);
    }

	public function tags(){

    	return $this->belongsToMany('App\Tag');
    }
    public function tagsByname($name){

    	return $this->belongsToMany('App\Tag')->where('name', $name);
    }

    public function suggested(){
       return DB::table('tag_user')->whereIn('tag_id', $this->tags);
    }
    public function gettagnames(){

    	return $this->belongsToMany('App\Tag')->pluck('name');
    }
    public function events()
    {
        return $this->hasMany(Event::class, 'event_id', 'id');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class, 'event_id', 'id');
    }

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }

    public function Invitations(){
        return $this->hasMany(Invitation::class, 'event_id')->pluck('receiver_id');
    }

    public function saveQuietly()
{
    return static::withoutEvents(function () {
        return $this->save();
    });
}
public function deleteQuietly()
{
    return static::withoutEvents(function () {
        return $this->delete();
    });
}

public function updateQuietly($request)
{
    $this->type = $request->type;
    $this->category = $request->category;
    $this->title = $request->title;
    $this->code = $request->code;
    $this->start_time = $request->start_time;
    $this->end_time = $request->end_time;
    $this->location = $request->location;
    $this->description = $request->description;
    $this->img = $request->img;
    $this->recurrence = $request->recurrence;
    $this->value = $request->value ? $request->value: 10;
    $this->user_id = Auth::id();
    static::withoutEvents(function () {
        return $this->update();
    });
}
    public function participations(){

    	return $this->belongsToMany('App\User',  'participations');
    }

    public function users_confirmed(){
    	return $this->belongsToMany('App\User','participations')->where('confirm_status', true);
    }

    public function users_interesed(){
    	return $this->belongsToMany('App\User','participations')->where('interest_status', true);
    }

    public function getStatus(){
        if($this->users_confirmed()->pluck('users.id')->contains(Auth::id())){
            $this->confirm_status = true;

        }else{
            $this->confirm_status = false;
        }
        if($this->users_interesed()->pluck('users.id')->contains(Auth::id())){
            $this->interest_status = true;
        }else{
            $this->interest_status = false;
        }
        if(Auth::user()->participationsWithoutRate->pluck('id')->contains($this->id)){
            $this->without_rate = true;
        }else{
            $this->without_rate = false;

        }
        return $this;
    }

    public function is_owner(){
        $id = Auth::id();
        if ($this->user_id == $id) {
            $this->is_owner = true;
            return $this;
        }else {
            $this->is_owner = false;
            return $this;
        }
    }

    public function createEvent($request){

        $this->type = $request->type;
        $this->category = $request->category;
        $this->title = $request->title;
        $this->code = $request->code;
        $this->start_time = $request->start_time;
        $this->end_time = $request->end_time;
        $this->location = $request->location;
        $this->description = $request->description;
        $this->recurrence = $request->recurrence;
        $this->img = $request->img;
        $this->value = $request->value ? $request->value: 10;
        $this->user_id = Auth::id();

        $this->save();

        Tag::TagMassive($request,$this,"initiative", $this);




    }
    public function updateEvent($request){

        $this->type = $request->type;
        $this->category = $request->category;
        $this->title = $request->title;
        $this->code = $request->code;
        $this->start_time = $request->start_time;
        $this->end_time = $request->end_time;
        $this->location = $request->location;
        $this->description = $request->description;
        $this->img = $request->img;
        $this->recurrence = $request->recurrence;
        $this->value = $request->value ? $request->value: 10;
        $this->user_id = Auth::id();

        $this->update();
        if($tags = explode(",", $request->tags)){
            $tagsbefore = $this->tags->pluck("id")->toArray();
            $tags = array_diff($tagsbefore, $tags);
            foreach($tagsbefore as $tag){
                $tag->event()->detach($this->id);
            }
            foreach ($tags as $tag) {
                if($tag_component = Tag::find($tag)){
                    $tag_component->events()->sync($this->id);
                }else{
                    $tag_component = new Tag;
                    $tag_component->createMassive($tag);
                    $tag_component->events()->sync($this->id);
                }
            }
        }
    }
}
