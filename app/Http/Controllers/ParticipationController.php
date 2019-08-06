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
}
