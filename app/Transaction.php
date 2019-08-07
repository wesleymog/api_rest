<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'type', 'description', 'user_id','value',
    ]; 

    public function createTransaction($request){

        $this->type = $request->type;
        $this->description = $request->description;
        $this->user_id = $request->user_id;
        $this->value = $request->value;
        
        $this->save();
    }

    public function updateTransaction($request){
        
        $this->type = $request->type;
        $this->description = $request->description;
        $this->user_id = $request->user_id;
        $this->value = $request->value;
        
        $this->save();
    }

    public function user(){
        return $this->belongsTo('App\User', 'foreign_key');
    }
    
}
