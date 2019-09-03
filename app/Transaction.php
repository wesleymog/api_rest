<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

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
        $this->code = Str::random(10);
        if($request->confirm_status == 0 || $request->confirm_status == 1){
            $this->confirm_status = $request->confirm_status;
        }
        
        $this->save();
    }

    public function updateTransaction($request){
        
        $this->type = $request->type;
        $this->description = $request->description;
        $this->user_id = $request->user_id;
        $this->value = $request->value;
        if($request->confirm_status == 0 || $request->confirm_status == 1){
            $this->confirm_status = $request->confirm_status;
        }
        
        $this->save();
    }

    public function user(){
        return $this->belongsTo('App\User', 'foreign_key');
    }
    
}
