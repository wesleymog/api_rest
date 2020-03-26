<?php

namespace App\Http\Controllers;

use App\Community;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\User;
use App\Event;
use App\Content;
use Illuminate\Support\Facades\DB;

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
            $community->UserIn();

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

        $data = ['msg'=>'Comunidade criada com sucesso!', 'data'=> ['Community'=> $community]];
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
        
        if(!$community = Community::find($request->community_id)){
            return response()->json(["data"=>["msg"=>"Community not found"]], 400);
        }

        if($subscribe = DB::table('community_user')->where('user_id',$user->id)->where('community_id',$community->id)->first()){
            $user->communities()->detach($community);
            return response()->json(["data"=>["msg"=>"Unsubscribe successful"]], 200);
        }else{
            $community->subscribeUser($request);
            return response()->json(["data"=>["msg"=>"Subscribe successful"]], 200);
        }
    }
    public function subscribeMyself(Request $request){
        $user = Auth::user();
        
        if(!$community = Community::find($request->community_id)){
            return response()->json(["data"=>["msg"=>"Community not found"]], 400);
        }

        if($subscribe = DB::table('community_user')->where('user_id',$user->id)->where('community_id',$community->id)->first()){
            $user->communities()->detach($community);
            return response()->json(["data"=>["msg"=>"Unsubscribe successful"]], 200);
        }else{
            $request->user_id = $user->id;
            $community->subscribeUser($request);
            return response()->json(["data"=>["msg"=>"Subscribe successful"]], 200);
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
// Documentação API

/**
 * @OA\Tag(
 *     name="communities",
 *     description="Everything about your communities",
 *     @OA\ExternalDocumentation(
 *         description="Find out more",
 *         url="http://swagger.io"
 *     )
 * )
 */

 /**
 * @OA\Get(
 *      path="/communities",
 *      operationId="getcommunities",
 *      tags={"communities"},
 *      summary="Get list of communities",
 *      description="Returns list of Communities",
 *      @OA\Response(
 *          response=200,
 *          description="successful operation"
 *       ),
 *       @OA\Response(response=400, description="Bad request"),
 *       security={
 *           {"api_key_security_example": {}}
 *       }
 *     )
 *
 * Returns list of communities
 */
   /**
 * @OA\Put(
 *      path="/communities/{id}",
 *      operationId="update_communitie",
 *      tags={"communities"},
 *      summary="Edit an communitie",
 *      description="Returns list of communities",
 *     @OA\RequestBody(
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 @OA\Property(property="name",type="string"),
 *                 @OA\Property(property="description",type="string"),
 *                 @OA\Property(property="img",type="string"),
 *                 example={"name":"test", "description": "teste", "img": "test"},
 *                 required={"name"}
 *             )
 *         )
 *     ),

 *      @OA\Response(
 *          response=200,
 *          description="successful operation"
 *       ),
 *       @OA\Response(response=400, description="Bad request"),
 *
 *     )
 *
 * Return an communitie Edited
 */
   /**
 * @OA\Get(
 *      path="/communities/{id}",
 *      operationId="single_communitie",
 *      tags={"communities"},
 *      summary="Get an communitie",
 *      description="Returns list of communities",
 *      @OA\Response(
 *          response=200,
 *          description="successful operation"
 *       ),
 *       @OA\Response(response=400, description="Bad request"),
 *
 *     )
 *
 * Return an communitie
 */

 /**
 * @OA\Post(
 *      path="/communities",
 *      operationId="add_communitie",
 *      tags={"communities"},
 *      summary="Add an communitie",
 *      description="Returns list of communities",
 *     @OA\RequestBody(
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 @OA\Property(property="name",type="string"),
 *                 @OA\Property(property="description",type="string"),
 *                 @OA\Property(property="img",type="string"),
 *                 example={"name":"test", "description": "teste", "img": "test"},
 *                 required={"name"}
 *             )
 *         )
 *     ),
 *      @OA\Response(
 *          response=200,
 *          description="successful operation"
 *       ),
 *       @OA\Response(response=400, description="Bad request"),
 *       security={
 *           {"api_key_security_example": {}}
 *       }
 *     )
 *
 *
 */

 /**
 * @OA\Delete(
 *      path="/communities/{id}",
 *      operationId="delete_community",
 *      tags={"com"},
 *      summary="Delete an communitie",
 *      description="Returns list of communities",
 *      @OA\Response(
 *          response=200,
 *          description="successful operation"
 *       ),
 *       @OA\Response(response=400, description="Bad request"),
 *
 *     )
 *
 * Return a message of success
 */

 /**
 * @OA\Post(
 *      path="/communities/subscribecontent",
 *      operationId="add_community_content",
 *      tags={"communities"},
 *      summary="Add a content to a community",
 *      description="Add a content to a community",
 *     @OA\RequestBody(
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 @OA\Property(property="content_id",type="integer"),
 *                 @OA\Property(property="community_id",type="integer"),
 *                 example={"content_id":1, "community_id": 1},
 *                 required={"content_id", "community_id"}
 *             )
 *         )
 *     ),
 *      @OA\Response(
 *          response=200,
 *          description="successful operation"
 *       ),
 *       @OA\Response(response=400, description="Bad request"),
 *       security={
 *           {"api_key_security_example": {}}
 *       }
 *     )
 *
 *
 */
/**
 * @OA\Post(
 *      path="/communities/subscribeevent",
 *      operationId="add_community_event",
 *      tags={"communities"},
 *      summary="Add a event to a community",
 *      description="Add a event to a community",
 *     @OA\RequestBody(
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 @OA\Property(property="event_id",type="integer"),
 *                 @OA\Property(property="community_id",type="integer"),
 *                 example={"event_id":1, "community_id": 1},
 *                 required={"event_id", "community_id"}
 *             )
 *         )
 *     ),
 *      @OA\Response(
 *          response=200,
 *          description="successful operation"
 *       ),
 *       @OA\Response(response=400, description="Bad request"),
 *       security={
 *           {"api_key_security_example": {}}
 *       }
 *     )
 *
 *
 */
/**
 * @OA\Post(
 *      path="/communities/subscribeuser",
 *      operationId="subscribe_community_user",
 *      tags={"communities"},
 *      summary="Subscribe an user in a community",
 *      description="Subscribe an user in a community",
 *     @OA\RequestBody(
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 @OA\Property(property="user_id",type="integer"),
 *                 @OA\Property(property="community_id",type="integer"),
 *                 @OA\Property(property="is_admin",type="boolean"),
 *                 example={"user_id":1, "community_id": 1, "is_admin":true},
 *                 required={"user_id", "community_id","is_admin"}
 *             )
 *         )
 *     ),
 *      @OA\Response(
 *          response=200,
 *          description="successful operation"
 *       ),
 *       @OA\Response(response=400, description="Bad request"),
 *       security={
 *           {"api_key_security_example": {}}
 *       }
 *     )
 *
 *
 */
/**
 * @OA\Post(
 *      path="/communities/subscribemyself",
 *      operationId="subscribe_community_myself",
 *      tags={"communities"},
 *      summary="Subscribe logged user in a community",
 *      description="Subscribe logged user in a community",
 *     @OA\RequestBody(
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 @OA\Property(property="community_id",type="integer"),
 *                 @OA\Property(property="is_admin",type="boolean"),
 *                 example={"user_id":1, "community_id": 1},
 *                 required={"user_id", "community_id"}
 *             )
 *         )
 *     ),
 *      @OA\Response(
 *          response=200,
 *          description="successful operation"
 *       ),
 *       @OA\Response(response=400, description="Bad request"),
 *       security={
 *           {"api_key_security_example": {}}
 *       }
 *     )
 *
 *
 */
