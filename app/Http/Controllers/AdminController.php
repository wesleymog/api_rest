<?php

namespace App\Http\Controllers;

use App\Admin;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use App\Event;
use Illuminate\Support\Facades\DB;
use App\Tag;
use App\User;
use Carbon\Carbon;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admin = new Admin();
        $data = [
            'tags_eventos'=>$admin->BestTagsInitiatives(),
            'tags_user'=> $admin->BestTagsUsers(),
            'events_user'=>$admin->MostConfirmedInitiatives(),
            'count_event'=>$admin->CountEventsByMonth()
        ];
        return response()->json($data, 200);
    }
    public function index1(){
        return 'oi';
    }

    public function dashboard(Request $request){
        $type = $request->type;
        $filters = $request->filters;
        if(!(array_key_exists("start_time", $filters))){
            $filters['start_time'] = "1950-03-11 21:55:38";
        }

        if(!(array_key_exists("end_time", $filters))){
            $filters['end_time'] = new Carbon('now');
        }
        if($type == 'participation'){
            $events = Event::where('end_time','>' ,$filters['start_time'])->where('end_time','<' ,$filters['end_time'])->get();

            foreach ($events as $event) {
                $event->participations = $event->participations()->count();
                $event->suggested = $event->suggested()->count();
                $event->notifications = $event->notifications()->count();
            }
            $events = $events->map->only('title','participations','suggested','notifications','start_time','end_time');
            return response()->json(['events'=>$events], 200);
        }elseif ($type == 'evaluation') {

        }elseif($type == 'initiativeCreated'){
            $eventcount = Event::where('start_time','>' ,$filters['start_time'])->where('end_time','<' ,$filters['end_time'])->count();
            return response()->json(["initiative created" => $eventcount], 200);

        }elseif($type == 'initiativeCreatedByType'){
            $eventcount = Event::where('type', $filters['type'])->where('start_time','>' ,$filters['start_time'])->where('end_time','<' ,$filters['end_time'])->count();
            return response()->json(["initiative created by Type" => $eventcount], 200);

        }elseif($type == 'initiativeCreatedByTags'){

            if($tag = Tag::find($filters['tag']));
            elseif($tag = DB::table('tags')->where("name",$filters['tag'])->first()){
                $tag = Tag::find($tag->id);
            }
            $eventcount = $tag->events->where('start_time','>' ,$filters['start_time'])->where('end_time','<' ,$filters['end_time'])->count();

            return response()->json(["initiative created by tag" => $eventcount], 200);

        }elseif($type == 'interests'){
            $users = User::all()->pluck("id");
            $tags = DB::table('tag_user')
                 ->where('category', 'interests')
                 ->whereIn('user_id', $users)
                 ->select('tag_id', DB::raw('count(*) as total'))
                 ->groupBy('tag_id')
                 ->get();
            $tags = $tags->sortByDesc('total')->values();
            foreach ($tags as $tag) {
                $tag->tag_id = Tag::find($tag->tag_id);
            }
            return response()->json(['interests', $tags], 200);
        }elseif($type == 'skills'){

            $users = User::all()->pluck("id");
            $tags = DB::table('tag_user')
                 ->where('category', 'skills')
                 ->whereIn('user_id', $users)
                 ->select('tag_id', DB::raw('count(*) as total'))
                 ->groupBy('tag_id')
                 ->get();
            $tags = $tags->sortByDesc('total')->values();
            foreach ($tags as $tag) {
                $tag->tag_id = Tag::find($tag->tag_id);
            }
            return response()->json(['skills', $tags], 200);
            }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly InitiativeCreated resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function show(Admin $admin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function edit(Admin $admin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Admin $admin)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function destroy(Admin $admin)
    {
        //
    }
}
