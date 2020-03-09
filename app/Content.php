<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Content extends Model
{
    protected $fillable = [
        'title', 'body','link'
    ];

    public function communities(){
        return $this->hasMany(Community::class);
    }

    public function createContent($request){

        $user = Auth::id();
        $this->user_id = $user;
        $this->title = $request->title;
        $this->body = $request->body;
        $this->link = $request->link;

        $this->save();
    }

    public function updateContent($request){

        $this->title = $request->title;
        $this->body = $request->body;
        $this->link = $request->link;

        $this->save();
    }



}
