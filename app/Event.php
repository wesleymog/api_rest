<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
	 protected $fillable = [
        'type', 'title', 'code','datetime', 'location', 'description','img','value',
    ];

	public function tags(){
    	
    	return $this->belongsToMany('App\Tag');
    }

}
