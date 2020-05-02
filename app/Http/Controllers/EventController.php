<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Events\NewInvite;
use Carbon\Carbon;
class EventController extends Controller
{
	public function index(){
    	$data = ['data' => Event::all()];
    	if(!Event::all()) return response()->json(['msg' => 'Nenhum Evento encontrado'], 404);
    	return response()->json($data);
    }

    public function show( $id){
        $event = Event::find($id);
        if(! $event) return response()->json([ 'msg' =>    'O evento não foi encontrado'], 404);
    	$event->tags;
        $event->users_confirmed;
        $event->is_owner();
        $event->getStatus();
    	return response()->json($event);
    }

    public function store(Request $request){
            $event = new Event;
            $event->createEvent($request);
    	    return response()->json(['msg' => 'Evento cadastrado com sucesso!', 'initiative' => $event], 201);

    }

    public function update(Request $request, $id){
        $EventData = $request->all();
        $event = Event::find($id);
        if(! $event) return response()->json(['msg' => 'Evento não encontrado'], 404);
        $event->updateEvent($request);

        return response()->json(['msg' => 'Evento Atualizado com sucesso!'], 201);


    }

    public function updateone(Request $request, $id){
        $EventData = $request->all();
        dd('oi');
        $event = Event::find($id);
        if(! $event) return response()->json(['msg' => 'Evento não encontrado'], 404);
        $event->updateQuietly($request);

        return response()->json(['msg' => 'Evento Atualizado com sucesso!'], 201);
    }

    public function delete($id){

            $event = Event::find($id);
            if(! $event) return response()->json(['msg' => 'Evento não encontrado'], 404);
            $event->delete();

            return response()->json(['msg' => 'Evento deletada com sucesso!'], 201);
    }

    public function deleteone($id){

        $event = Event::find($id);
            if(! $event) return response()->json(['msg' => 'Evento não encontrado'], 404);
            $event->deleteQuietly();

            return response()->json(['msg' => 'Evento deletada com sucesso!'], 201);
    }

    public function autocomplete(Request $request){
        if($request->max) $max = $request->max;
        else $max = 5;

        $data = Event::select("*")
                ->where("title","LIKE","%{$request->title}%")
                ->take($max)
                ->get();

        return response()->json($data);
    }
    public function search(Request $request){
        $data = Event::select("*")
                ->where("title","LIKE","%{$request->title}%")
                ->get();

        return response()->json($data);
    }

    public function invitation($id){

        $event = Event::find($id);
        $users = $event->Invitations();
        $users = User::findMany($users);

        return response()->json($users, 200);

    }
}



// Documentação API

/**
 * @SWG\Tag(
 *     name="Events",
 *     description="Everything about your Events",
 *     @SWG\ExternalDocumentation(
 *         description="Find out more",
 *         url="http://swagger.io"
 *     )
 * )
 */

 /**
 * @SWG\Get(
 *      path="/events",
 *      operationId="getEvents",
 *      tags={"Events"},
 *      summary="Get list of Events",
 *      description="Returns list of Evennts",
 *      @SWG\Response(
 *          response=200,
 *          description="successful operation"
 *       ),
 *       @SWG\Response(response=400, description="Bad request"),
 *       security={
 *           {"api_key_security_example": {}}
 *       }
 *     )
 *
 * Returns list of Events
 */
   /**
 * @SWG\Put(
 *      path="/events/{id}",
 *      operationId="update_event",
 *      tags={"Events"},
 *      summary="Edit an Event",
 *      description="Returns list of Events",
 *     @SWG\RequestBody(
 *         @SWG\MediaType(
 *             mediaType="application/json",
 *             @SWG\Schema(
 *                 @SWG\Property(
 *                     property="type",
 *                     type="integer"
 *                 ),
 *                 @SWG\Property(
 *                     property="title",
 *                     type="string"
 *                 ),
 *                 @SWG\Property(
 *                     property="code",
 *                     type="string"
 *                 ),
 *                 @SWG\Property(
 *                     property="category",
 *                     type="string"
 *                 ),
 *                 @SWG\Property(
 *                     property="start_time",
 *                     type="datetime"
 *                 ),
 *                 @SWG\Property(
 *                     property="end_time",
 *                     type="datetime"
 *                 ),
 *                 @SWG\Property(
 *                     property="location",
 *                     type="string"
 *                 ),
 *                 @SWG\Property(
 *                     property="description",
 *                     type="string"
 *                 ),
 *                 @SWG\Property(
 *                     property="img",
 *                     type="string"
 *                 ),
 *                 @SWG\Property(
 *                     property="value",
 *                     type="double"
 *                 ),
 *                 @SWG\Property(
 *                     property="user_id",
 *                     type="integer"
 *                 ),
 *                 @SWG\Property(
 *                     property="tags",
 *                     type="string"
 *                 ),
 *                 @SWG\Property(
 *                     property="recurrence",
 *                     type="string"
 *                 ),
 *                 example={"type": 1,"title": "olg","code": "#a101","category": "1","start_time": "2019-12-28 20:45:12","end_time": "2019-08-30 23:05:12","location": "Carrin","description": "legal","img": null,"value":10,"user_id": 1,"tags":"teste, feliz, sad, test","recurrence": "monthly"},
 *                 required={"type","title","code","category", "start_time", "end_time","location","description", "img", "value","recurrence"}
 *             )
 *         )
 *     ),

 *      @SWG\Response(
 *          response=200,
 *          description="successful operation"
 *       ),
 *       @SWG\Response(response=400, description="Bad request"),
 *
 *     )
 *
 * Return an Event Edited
 */
   /**
 * @SWG\Get(
 *      path="/events/{id}",
 *      operationId="single_event",
 *      tags={"Events"},
 *      summary="Get an Event",
 *      description="Returns list of Events",
 *      @SWG\Response(
 *          response=200,
 *          description="successful operation"
 *       ),
 *       @SWG\Response(response=400, description="Bad request"),
 *
 *     )
 *
 * Return an Event
 */

 /**
 * @SWG\Post(
 *      path="/events",
 *      operationId="add_event",
 *      tags={"Events"},
 *      summary="Add an Event",
 *      description="Returns list of Events",
 *     @SWG\RequestBody(
 *         @SWG\MediaType(
 *             mediaType="application/json",
 *             @SWG\Schema(
 *                 @SWG\Property(
 *                     property="type",
 *                     type="integer"
 *                 ),
 *                 @SWG\Property(
 *                     property="title",
 *                     type="string"
 *                 ),
 *                 @SWG\Property(
 *                     property="code",
 *                     type="string"
 *                 ),
 *                 @SWG\Property(
 *                     property="category",
 *                     type="string"
 *                 ),
 *                 @SWG\Property(
 *                     property="start_time",
 *                     type="datetime"
 *                 ),
 *                 @SWG\Property(
 *                     property="end_time",
 *                     type="datetime"
 *                 ),
 *                 @SWG\Property(
 *                     property="location",
 *                     type="string"
 *                 ),
 *                 @SWG\Property(
 *                     property="description",
 *                     type="string"
 *                 ),
 *                 @SWG\Property(
 *                     property="img",
 *                     type="string"
 *                 ),
 *                 @SWG\Property(
 *                     property="value",
 *                     type="double"
 *                 ),
 *                 @SWG\Property(
 *                     property="user_id",
 *                     type="integer"
 *                 ),
 *                 @SWG\Property(
 *                     property="tags",
 *                     type="string"
 *                 ),
 *                 @SWG\Property(
 *                     property="recurrence",
 *                     type="string"
 *                 ),
 *                 example={"type": 1,"title": "olg","code": "#a101","category": "1","start_time": "2019-12-28 20:45:12","end_time": "2019-08-30 23:05:12","location": "Carrin","description": "legal","img": null,"value":10,"user_id": 1,"tags":"teste, feliz, sad, test","recurrence": "monthly"},
 *                 required={"type","title","code","category", "start_time", "end_time","location","description", "img", "value","recurrence"}
 *             )
 *         )
 *     ),
 *      @SWG\Response(
 *          response=200,
 *          description="successful operation"
 *       ),
 *       @SWG\Response(response=400, description="Bad request"),
 *       security={
 *           {"api_key_security_example": {}}
 *       }
 *     )
 *
 *
 */

 /**
 * @SWG\Delete(
 *      path="/events/{id}",
 *      operationId="delete_event",
 *      tags={"Events"},
 *      summary="Delete an Event",
 *      description="Returns list of Events",
 *      @SWG\Response(
 *          response=200,
 *          description="successful operation"
 *       ),
 *       @SWG\Response(response=400, description="Bad request"),
 *
 *     )
 *
 * Return a message of success
 */
