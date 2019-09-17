<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;
use App\Tag;

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
        $users = $event->users_confirmed;
    	return response()->json($event);
    }

    public function store(Request $request){
            $event = new Event;
            $event->createEvent($request);
    	    return response()->json(['msg' => 'Evento cadastrado com sucesso!'], 201);          

    }

    public function update(Request $request, $id){
        $EventData = $request->all();
        $event = Event::find($id);
        if(! $event) return response()->json(['msg' => 'Evento não encontrado'], 404);
        $event->updateEvent($request);

        return response()->json(['msg' => 'Evento Atualizado com sucesso!'], 201);


    }
    public function delete($id){
        try {
            $event = Event::find($id);
            if(! $event) return response()->json(['msg' => 'event não encontrado'], 404);
            $event->delete();
            
            return response()->json(['msg' => 'event deletada com sucesso!'], 201);
            
        } catch (\Exception $e) {
            
            return response()->json(['msg' => 'Houve um erro na hora de deletar!'], 500);
            
        }

    }
}



// Documentação API

/**
 * @OA\Tag(
 *     name="Events",
 *     description="Everything about your Events",
 *     @OA\ExternalDocumentation(
 *         description="Find out more",
 *         url="http://swagger.io"
 *     )
 * )
 */

 /**
 * @OA\Get(
 *      path="/events",
 *      operationId="getEvents",
 *      tags={"Events"},
 *      summary="Get list of Events",
 *      description="Returns list of Evennts",
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
 * Returns list of Events
 */
   /**
 * @OA\Put(
 *      path="/events/{id}",
 *      operationId="update_event",
 *      tags={"Events"},
 *      summary="Edit an Event",
 *      description="Returns list of Events",
 *      @OA\Response(
 *          response=200,
 *          description="successful operation"
 *       ),
 *       @OA\Response(response=400, description="Bad request"),
 *       
 *     )
 *
 * Return an Event Edited
 */
   /**
 * @OA\Get(
 *      path="/events/{id}",
 *      operationId="single_event",
 *      tags={"Events"},
 *      summary="Get an Event",
 *      description="Returns list of Events",
 *      @OA\Response(
 *          response=200,
 *          description="successful operation"
 *       ),
 *       @OA\Response(response=400, description="Bad request"),
 *       
 *     )
 *
 * Return an Event
 */

 /**
 * @OA\Post(
 *      path="/events",
 *      operationId="add_event",
 *      tags={"Events"},
 *      summary="Add an Event",
 *      description="Returns list of Events",
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
 * Returns list of Events
 */

 /**
 * @OA\Delete(
 *      path="/events/{id}",
 *      operationId="delete_event",
 *      tags={"Events"},
 *      summary="Delete an Event",
 *      description="Returns list of Events",
 *      @OA\Response(
 *          response=200,
 *          description="successful operation"
 *       ),
 *       @OA\Response(response=400, description="Bad request"),
 *       
 *     )
 *
 * Return a message of sucess
 */
