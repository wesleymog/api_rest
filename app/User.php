<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 
        'admission', 'occupation', 'sector', 
        'institute', 'first_access','img'
        ,'wallet',
    ];
    
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    public function tags(){
        return $this->belongsToMany(Tag::class);
    }

    public function transactions(){
        return $this->hasMany(Transaction::class);
    }

    public function alterWallet($value){
        $this->wallet += $request->value;

        $this->save();
    }

     public function createUser($request){

        $this->name = $request->name;
        $this->email = $request->email;
        $this->password = $request->password;
        $this->admission = $request->admission;
        $this->occupation = $request->occupation;
        $this->sector = $request->sector;
        $this->institute = $request->institute;
        $this->first_access = $request->first_access;
        $this->save();

        //Tratamento das Tags
        if($tags = explode(",", $request->tags)){
            foreach ($tags as $tag) {
                if($tag_component = Tag::find($tag)){
                    $tag_component->users()->attach($this);
                }
            }   
        }
    }
}
