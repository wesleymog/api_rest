<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reward extends Model
{
    protected $fillable = [
        'title','description', 'img', 'stock', 'value', 'guide'
    ];
    
    public function users(){
    	return $this->belongsToMany('App\User');
    }

    public function createReward($request){

        $this->title = $request->title;
        $this->description = $request->description;
        $this->img = $request->img;
        $this->stock = $request->stock;
        $this->value = $request->value;
        $this->guide = $request->guide;

        $this->save();
    }

    public function CreateRewardUser(){
        $this->users()->attach($this, ['code'=>str_random(40)]);
        $this->stock -=1;
        $this->save();
    }

    public function updateTransaction($request){
        
        $this->title = $request->title;
        $this->description = $request->description;
        $this->img = $request->img;
        $this->stock = $request->stock;
        $this->value = $request->value;
        $this->guide = $request->guide;
        
        $this->save();
    }


}
