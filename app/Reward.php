<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reward extends Model
{
    protected $fillable = [
        'title','description', 'img', 'stock', 'value', 'guide'
    ];

    public function createReward($request){

        $this->title = $request->title;
        $this->description = $request->description;
        $this->img = $request->img;
        $this->stock = $request->stock;
        $this->value = $request->value;
        $this->guide = $request->guide;

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
