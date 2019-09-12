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
        'name',
        'birthday', 
        'email', 
        'password', 
        'admission', 
        'position', 
        'sector', 
        'education',
        'university', 
        'first_access',
        'place_of_birth',
        'wallet',
        'profile_picture',
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
        $this->wallet += $value;

        $this->save();
    }
    public function responseCommunitybyTag(){
        //Select user's tag
        $tags = $this->tags;
        //starting a new collection
        $community = collect();

        foreach ($tags as $tag) {

            $users = collect();
            //Creating a new tag with users
            $users = $users->merge(['name'=>$tag->name,'users'=> $tag->users->pluck('id')]);
            
            $community = $community->push($users);
        }
        //dd($community->());
        $community = $community->sortByDesc(function ($product, $key) {
            return count($product['users']);
        });
        return $community->values()->all();
    }

     public function createUser($request){

        $this->name = $request->name;
        $this->birthday = $request->birthday;
        $this->email = $request->email;
        $this->password = $request->password;
        $this->admission = $request->admission;
        $this->position = $request->position;
        $this->sector = $request->sector;
        $this->education = $request->education;
        $this->university = $request->university;
        $this->place_of_birth = $request->place_of_birth;
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
