<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
     protected $fillable = [
        'name', 'category',
    ];

    public function users(){
        return $this->belongsToMany(User::class);
    }

    public function events(){
        return $this->belongsToMany(Event::class);
    }
}
