<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
     protected $fillable = [
        'name',
    ];

    public function users(){
    	return $this->belongsToMany('App\User');
    }

    public function events(){
        return $this->belongsToMany(Event::class);
    }
    public function create($request){
        $this->name = $request->name;
        $this->save();
        return $this;
    }

    public function createMassive($name){
        $this->name = $name;
        $this->save();
        return $this;
    }


    public function updateTag($request){
        $this->name = $request->name;
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
        if($skills = explode(",", $request->skills)){
            foreach ($skills as $skill) {
                if($tag_component = Tag::find($skill)){
                    $tag_component->users()->attach($object,['category'=>'skills']);
                }
                else{
                    $tag_component = new Tag;
                    $tag_component->createMassive($skill);
                    $tag_component->users()->attach($object,['category'=>'skills']);
                }
            }

        }
        if($interests = explode(",", $request->interests)){
            foreach ($interests as $interest) {
                if($tag_component = Tag::find($interest)){
                    $tag_component->users()->attach($object,['category'=>'interests']);
                }
                else{
                    $tag_component = new Tag;
                    $tag_component->createMassive($interest);
                    $tag_component->users()->attach($object,['category'=>'interests']);
                }
            }

        }
    }
}
