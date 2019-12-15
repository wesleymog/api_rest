<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Participation;
use App\Transaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ParticipationController extends Controller
{
    public function confirmation(Request $request){

        $user = Auth::id();
        $request['user_id'] = $user;
        // $user = User::find($request->user);
        // $event = Event::find($request->event);
        if( $response = DB::table('participations')->where([
            ['user_id', '=', $user],
            ['event_id', '=', $request->event_id],
        ])->first()){
            $participation = Participation::find($response->id);
            $participation->updateParticipation($request);
             }else{
            $participation = new Participation;
            $participation->createParticipation($request);

            }
            if($request->confirm_status == 0) return response()->json(['msg' => 'Desconfirmamos sua participação no evento!'], 201);
            if($request->confirm_status == 1) return response()->json(['msg' => 'Confirmamos sua participação no evento!'], 201);
            if($request->interest_status == 0) return response()->json(['msg' => 'Desconfirmamos seu interesse no evento!'], 201);
            if($request->interest_status == 1) return response()->json(['msg' => 'Confirmamos seu interesse no evento!'], 201);

    }

    public function interest(Request $request){

    $user = Auth::id();
    $request['user_id'] = $user;      // $user = User::find($request->user);
    // $event = Event::find($request->event);
    if( $response = DB::table('participations')->where([
        ['user_id', '=', $user],
        ['event_id', '=', $request->event_id],
    ])->first()){
        $participation = Participation::find($response->id);
        $participation->updateParticipation($request);
    }else{
        $participation = new Participation;
        $participation->createParticipation($request);

    }

    if($request->interest_status == 0) return response()->json(['msg' => 'Desconfirmamos seu interesse no evento!'], 201);
    if($request->interest_status == 1) return response()->json(['msg' => 'Confirmamos seu interesse no evento!'], 201);

  }

    public function rating(Request $request){
        $user = Auth::id();
        $request['user_id'] = $user;
        $participation = DB::table('participations')->where('user_id', $user)->where('event_id', $request->event_id)->first();
        if($participation){
            if($request->status == true){
                $participation = Participation::find($participation->id);
                $participation->updateParticipation($request);

                // Fazendo transação
                $transaction = new Transaction;
                $transaction->participationTransaction($participation);


                return response()->json(['msg' => 'Obrigado por sua avaliação', 'participation'=> $participation, 'transaction'=> $transaction], 201);
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
 *
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

/*paths:
/participation:
  post:
    requestBody:
      required: true
      content:
        application/json:
          schema:
            type: object
            properties:
              user_id:
                type: integer
              event_id:
                type: integer
              confirmation_status:
                  type: integer
 */
