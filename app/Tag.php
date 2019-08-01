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
}
