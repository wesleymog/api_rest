<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
     protected $fillable = [
        'name', 'category',
    ];

    public function users(){
    	return $this->belongsToMany('App\User');
    }

    public function events(){
        return $this->belongsToMany(Event::class);
    }
    public function create($request){
        $this->name = $request->name;
        $this->category = $request->category;
        $this->save();
        return $this;
    }

    public function createMassive($name){
        $this->name = $name;
        $this->category = "byuser";
        $this->save();
        return $this;
    }


    public function updateTag($request){
        $this->name = $request->name;
        $this->category = $request->category;
        $this->save();
        return $this;
    }

    public function RelationshipTags($request, $object){
        if($tags = explode(",", $request->tags)){
            foreach ($tags as $tag) {
                if($tag_component = Tag::find($tag)){
                    $tag_component->users()->attach($this);
                }
            }
        }
    }
}
