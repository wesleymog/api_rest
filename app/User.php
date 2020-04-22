<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\HasApiTokens;
use App\Event;
use App\Invitation;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;


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
        'date_of_birth',
        'email',
        'password',
        'main_area',
        'area',
        'supervisor',
        'admission',
        'position',
        'branch_office',
        'city',
        'country',
        'phone_number',
        'education',
        'education_institute',
        'first_access',
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
    public function notifications(){
        return $this->hasMany(Notification::class);
    }

    public function communities(){
        return $this->belongsToMany(Community::class);
    }
    public function tags(){
        return $this->belongsToMany(Tag::class);
    }

    public function rewards(){
        return $this->belongsToMany(Reward::class);
    }

    public function transactions(){
        return $this->hasMany(Transaction::class);
    }
    public function Myevents(){
         return Event::where('user_id', $this->id)->orderBy('end_time', 'desc')->get();
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

    public function eventsHeld(){

        $carbon =Carbon::now( 'America/Sao_Paulo')->toDateTimeString();

        return $this->belongsToMany('App\Event', 'participations')->wherePivot('confirm_status', 1)->where('events.end_time','<',$carbon);
    }

    public function participationsWithoutRate()
    {
        $carbon =Carbon::now( 'America/Sao_Paulo')->toDateTimeString();

        return $this->belongsToMany('App\Event', 'participations')->wherePivot('rate',null)->wherePivot('status',null)->where('events.end_time','<',$carbon);
    }

    public function myInvitationstoOthers(){
        return $this->hasMany(Invitation::class, 'sender_id');
    }

    public function myInvitationsbyEvent($event_id){
        return $this->hasMany(Invitation::class, 'sender_id')->where('event_id', $event_id);
    }

    public function myInvitations(){
        return $this->hasMany(Invitation::class, 'receiver_id');
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
        $this->date_of_birth = $request->date_of_birth;
        $this->email = $request->email;
        $this->password = bcrypt($request->password);
        $this->main_area = $request->main_area;
        $this->area = $request->area;
        $this->supervisor = $request->supervisor;
        $this->admission = $request->admission;
        $this->position = $request->position;
        $this->branch_office = $request->branch_office;
        $this->city = $request->city;
        $this->country = $request->country;
        $this->phone_number = $request->phone_number;
        $this->education = $request->education;
        $this->education_institute = $request->education_institute;
        $this->first_access = $request->first_access;
        $this->save();
        Tag::TagMassive($request,"user", $this);
    }
    public function updateUser($request){
        if($request->name!=null)$this->name = $request->name;
        if($request->date_of_birth!=null)$this->date_of_birth = $request->date_of_birth;
        if($request->email!=null)$this->email = $request->email;
        if($request->password!=null)$this->password = bcrypt($request->password);
        if($request->main_area!=null)$this->main_area = $request->main_area;
        if($request->area!=null)$this->area = $request->area;
        if($request->supervisor!=null)$this->supervisor = $request->supervisor;
        if($request->admission!=null)$this->admission = $request->admission;
        if($request->position!=null)$this->position = $request->position;
        if($request->branch_office!=null)$this->branch_office = $request->branch_office;
        if($request->city!=null)$this->city = $request->city;
        if($request->country!=null)$this->country = $request->country;
        if($request->phone_number!=null)$this->phone_number = $request->phone_number;
        if($request->education!=null)$this->education = $request->education;
        if($request->education_institute!=null)$this->education_institute = $request->education_institute;
        if($request->first_access!=null)$this->first_access = $request->first_access;
        if($request->profile_picture!=null)$this->profile_picture = $request->profile_picture;

        $this->update();
        dd(["request"=>$request->first_access, "database"=>$this->first_access]);
        if($request->tags){
            if($tags = explode(",", $request->tags)){
                $tagsbefore = $this->tags->pluck("id")->toArray();
                $tags = array_diff($tagsbefore, $tags);
                foreach($tagsbefore as $tag){
                    $tag->user()->detach($this->id);
                }
                foreach ($tags as $tag) {
                    if($tag_component = Tag::find($tag)){
                        $tag_component->users()->sync($this->id);
                    }else{
                        $tag_component = new Tag;
                        $tag_component->createMassive($tag);
                        $tag_component->users()->sync($this->id);
                    }
                }
            }
        }



    }

    public function sendPicture($image){
        $imageName = rand(111111111, 999999999) . '.png';
        $p = Storage::disk('s3')->put('profilePicture/' , $image, 'public');
        $this->profile_picture = "https://s3.us-east-2.amazonaws.com/mojo-event-images".$p;
        $this->save();
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
