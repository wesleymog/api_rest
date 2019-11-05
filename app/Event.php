<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
	 protected $fillable = [
        'type','category', 'title', 'code','start_time'
        ,'end_time', 'location', 'description','img','value','user_id'
    ];

	public function tags(){

    	return $this->belongsToMany('App\Tag');
    }

    public function participations(){

    	return $this->hasMany('App\Participation');
    }

    public function users_confirmed(){

    	return $this->belongsToMany('App\User','participations');
    }

    public function is_owner($id){
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
        $this->img = $request->img;
        $this->value = $request->value ? $request->value: 10;
        $this->user_id = Auth::id;

        $this->save();

        Tag::TagMassive($request,"initiative", $this);


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
        $this->value = $request->value ? $request->value: 10;
        $this->user_id = 1;

        $this->save();
        if($tags = explode(",", $request->tags)){
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
