<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
	 protected $fillable = [
        'type', 'title', 'code','start_time','end_time', 'location', 'description','img','value','user_id'
    ];

	public function tags(){
    	
    	return $this->belongsToMany('App\Tag');
    }

    public function createEvent($request){

        $this->type = $request->type;
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
                    $tag_component->events()->attach($this);
                }
            }   
        }

    }
    public function updateEvent($request){

        $this->type = $request->type;
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
                }
            }   
        }
    }
}
