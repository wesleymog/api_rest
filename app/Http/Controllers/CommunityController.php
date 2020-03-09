<?php

namespace App\Http\Controllers;

use App\Community;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\User;
use App\Event;
use App\Content;
class CommunityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $communities = Community::all();
        foreach ($communities as $community ) {
            $community->users;
            $community->events;
            $community->contents;
        }

        $data = ['data'=> ['Communities'=> $communities]];
        return response()->json($data, 200);
    }

    public function myCommunities(){
        $user = Auth::user();
        $communities = $user->communities()->get();
        $data = ['data'=> ['Communities'=> $communities]];
        return response()->json($data, 200);
    }

    public function EventsByCommunities(Community $community){
        $events = $community->events()->get();
        $data = ['data'=> ['events'=> $events]];
        return response()->json($data, 200);
    }

    public function ContentByCommunities(Community $community){
        $contents = $community->events()->get();
        $data = ['data'=> ['contents'=> $contents]];
        return response()->json($data, 200);
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $community = new Community;
        $community->createCommunity($request);
        $data = ['data'=> ['Community'=> $community]];
        return response()->json($data, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Community  $community
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $community = Community::find($id);
        $community->users;
        $community->events;
        $community->contents;
        $data = ['data'=> ['Community'=> $community]];
        return response()->json($data, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Community  $community
     * @return \Illuminate\Http\Response
     */
    public function edit(Community $community)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Community  $community
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $community = Community::find($id);
        $userId =  Auth::id();
        if(!$community->admin()->where('id', $userId)->exists()){
            return response()->json(['msg' => 'Forbidden'], 400);
        }
        $community = new Community;
        $community->createCommunity($request);
        $data = ['data'=> ['Community'=> $community]];
        return response()->json($data, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Community  $community
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $community = Community::find($id);
        $userId =  Auth::user();
        if(!$community->admin()->where('id', $userId)->exists()){
            return response()->json(['msg' => 'Forbidden'], 400);
        }
        $community->delete();
        return response()->json(["data"=>["msg"=>"deleted successful"]], 200);

    }

    public function subscribeUser(Request $request){
        if (!$user = User::find($request->user_id)) {
            return response()->json(["data"=>["msg"=>"User not found"]], 400);
        }
        if($community = Community::find($request->community_id)){
            $community->subscribeUser($request);
            return response()->json(["data"=>["msg"=>"Subscribe successful"]], 200);
        }else{
            return response()->json(["data"=>["msg"=>"Community not found"]], 400);
        }
    }
    public function subscribeMyself(Request $request){
        $user = Auth::id();
        if($community = Community::find($request->community_id)){
            $request->user_id = $user;
            $community->subscribeUser($request);
            return response()->json(["data"=>["msg"=>"Subscribe successful"]], 200);

        }else{
            return response()->json(["data"=>["msg"=>"Community not found"]], 400);
        }
    }
    public function subscribeEvent(Request $request){
        if (!Event::find($request->event_id)) {
            return response()->json(["data"=>["msg"=>"Event not found"]], 400);
        }
        if($community = Community::find($request->community_id)){
            $community->subscribeEvent($request);
            return response()->json(["data"=>["msg"=>"Subscribe successful"]], 200);

        }else{
            return response()->json(["data"=>["msg"=>"Community not found"]], 400);
        }
    }

    public function subscribeContent(Request $request){
        if (!Content::find($request->content_id)) {
            return response()->json(["data"=>["msg"=>"Content not found"]], 400);
        }
        if($community = Community::find($request->community_id)){
            $community->subscribeContent($request);
            return response()->json(["data"=>["msg"=>"Subscribe successful"]], 200);

        }else{
            return response()->json(["data"=>["msg"=>"Community not found"]], 400);
        }

    }


}
