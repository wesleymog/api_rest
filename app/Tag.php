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
    public static function TagMassive($request,$type ,$object){

        //Tratamento das Tags
        if($tags = explode(",", $request->tags)){
            foreach ($tags as $tag) {
                if($tag_component = Tag::find($tag)){
                    if($type == "initiative"){
                        $tag_component->events()->attach($object);
                    }else if($type == "user"){
                        $tag_component->users()->attach($object);
                    }
                }
                else if($tag_component = Tag::where('name', $tag)->first()){
                    if($type == "initiative"){
                        $tag_component->events()->attach($object);
                    }else if($type == "user"){
                        $tag_component->users()->attach($object);
                    }
                }
                else{
                    $tag_component = new Tag;
                    $tag_component->createMassive($tag);
                    if($type == "initiative"){
                        $tag_component->events()->sync($object->id);
                    }else if($type == "user"){
                        $tag_component->users()->sync($object->id);
                    }
                }
            }
        }
    }
}
