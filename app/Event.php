<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
	 protected $fillable = [
        'type', 'title', 'code','datetime', 'location', 'description',
    ];

	public function tags(){
    	
    	return $this->hasMany('App\Tag', 'id_tag', 'id');
    }

}
