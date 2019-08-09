<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
	 protected $fillable = [
        'type', 'title', 'code','start_time','end_time', 'location', 'description','img','value',
    ];

	public function tags(){
    	
    	return $this->belongsToMany('App\Tag');
    }
}
