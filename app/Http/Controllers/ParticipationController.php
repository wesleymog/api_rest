<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Participation;
use Illuminate\Support\Facades\DB;

class ParticipationController extends Controller
{
    public function confirmation(Request $request){
        
        // $user = Auth::id();
        // $user = User::find($request->user);
        // $event = Event::find($request->event);
        if( $response = DB::table('participations')->where([
            ['user_id', '=', $request->user_id],
            ['event_id', '=', $request->event_id],
        ])->first()){
            $participation = Participation::find($response->id);
            $participation->updateParticipation($request);
            if($request->confirm_status == 0){
                return response()->json(['msg' => 'Desconfirmamos sua participação no evento!'], 201);
            }else{
                return response()->json(['msg' => 'Confirmamos sua participação no evento!'], 201);
            }

        }else{
            $participation = new Participation;
            $participation->createParticipation($request);

            return response()->json(['msg' => 'Confirmamos sua participação no evento!'], 201);
        }

    }
    public function rating(Request $request){
        $participation = DB::table('participations')->where('user_id', $request->user_id)->where('event_id', $request->event_id)->first();
        if($participation){
            if($request->status == true){
                $participation = Participation::find($participation->id);
                $participation->updateParticipation($request);
                return response()->json(['msg' => 'Obrigado por sua avaliação', 'participation'=> $participation], 201);
            }elseif ($request->status == false) {
                $participation = Participation::find($participation->id);
                $participation->updateParticipation($request);
                return response()->json(['msg' => 'Que pena que você não foi ao evento, haverá uma próxima!', 'participation'=> $participation], 201);            
            }
        }else{
            return response()->json(['msg' => 'Participação no evento não encontrada'], 404);
        }
    }
}

//Documentação da API


/**
 * @OA\Tag(
 *     name="participation",
 *     description="Everything about your participations",
 * )
 */

 /**
 * @OA\Post(
 *      path="/participation",
 *      operationId="confirmation_participation",
 *      tags={"participation"},
 *      summary="Confirm your participation",
 *      description="Confirm a participation of an user",
 *      @OA\Response(
 *          response=200,
 *          description="successful operation"
 *       ),
 *       @OA\Response(response=400, description="Bad request"),
 *     )
 *
 * Return the participation of the user
 */
   /**
 * @OA\Post(
 *      path="/participation/rate",
 *      operationId="rate_participation",
 *      tags={"participation"},
 *      summary="Rate your participation in an event",
 *      description="Returns your rate in the event",
 *      @OA\Response(
 *          response=200,
 *          description="successful operation"
 *       ),
 *       @OA\Response(response=400, description="Bad request"),
 *       
 *     )
 *
 * Rate your participation in an event
 */
