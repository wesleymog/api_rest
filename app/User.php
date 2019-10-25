<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\HasApiTokens;
use App\Event;

class User extends Authenticatable
{
    use Notifiable,HasApiTokens;


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
        'is_admin',
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

    public function rewards(){
        return $this->belongsToMany(Reward::class);
    }

    public function transactions(){
        return $this->hasMany(Transaction::class);
    }

    public function alterWallet($value){
        if($this->wallet + $value >= 0){
            $this->wallet += $value;
            $this->save();
            return true;
        }else{
            return false;
        }
    }

    public function myJourney()
    {
        return $this->belongsToMany('App\Event', 'participations')->wherePivot('status', 1);
    }

    public function eventsConfirmed(){

        return $this->belongsToMany('App\Event', 'participations')->wherePivot('confirm_status', 1)->wherePivot('status',NULL);
    }

    public function participationsWithoutRate()
    {
        return $this->belongsToMany('App\Event', 'participations')->wherePivot('rate',null)->wherePivot('status',null);
    }

    public function responseCommunitybyTag(){
        $community = collect();

        foreach ($this->tags as $tag) {

            $users = collect();

            //Pegando os usuários relacionados à uma tag específica
            $user_by_tag = $tag->users()->where('user_id','!=',$this->id)->pluck('users.id');

            //Checando se há algum usuário nessa tag do usuário
            if($user_by_tag->count() >0){

                $users = $users->merge(['name'=>$tag->name,'users'=> $user_by_tag]);

                $community = $community->push($users);
            }

        }
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
                }else{
                    $tag_component = new Tag;
                    $tag_component->createMassive($tag);
                    $tag_component->users()->sync($this->id);
                }
            }
        }
    }
    public function updateUser($request){
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
                }else{
                    $tag_component = new Tag;
                    $tag_component->createMassive($tag);
                    $tag_component->users()->sync($this->id);
                }
            }
        }
    }
    public function myinitiatives()
    {
        $events = Event::where('user_id', $this->id)->orderBy('start_time', 'desc')->get();
        $eventswithconfirmed = collect();
        foreach ($events as $event) {
            $event->users_confirmed;
            $eventswithconfirmed = $eventswithconfirmed->push($event);
        }
        return $eventswithconfirmed;
        //return DB::table('events')->where('user_id', $this->id)->orderBy('start_time', 'desc')->get();
    }


    public function eventsInteresed(){

        return $this->belongsToMany('App\Event', 'participations')->wherePivot('interest_status', 1)->wherePivot('status',NULL);
    }
}
