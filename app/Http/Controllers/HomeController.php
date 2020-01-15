<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Event;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function alta(){
        $user =  Auth::user();
        $tags = $user->tags->pluck('id');
        $carbon =Carbon::now( 'America/Sao_Paulo')->toDateTimeString();
        $events = Event::where('start_time','>',$carbon)->withCount('users_confirmed')->orderBy('boost', 'desc')->get();

        foreach ($events as $event) {
            $event->getStatus();
        }

        return response()->json(['data'=>['alta'=>$events]], 200);
    }

    public function proximas(){
        $user =  Auth::user();
        $tags = $user->tags->pluck('id');
        $carbon =Carbon::now( 'America/Sao_Paulo')->toDateTimeString();
        if($tags->count() <= 0){
            $events = Event::where('start_time','>',$carbon)->orderBy('start_time', 'asc')->get();
            return response()->json(['data'=>["Proximas"=>$events,'msg'=>'Você não possui filtros']], 200);
        }
        $events = DB::table('event_tag')->whereIn('tag_id', $tags)->pluck("event_id");
        $events = Event::whereIn('id', $events)->where('end_time','>',$carbon)->paginate(10);

        foreach ($events as $event) {
            $event->getStatus();
        }

        return response()->json(['data'=>['proximas'=> $events]], 200);

    }

    public function home(){

        $user = Auth::user();

        $tags = $user->tags->pluck("id");
        //checando se não há nenhuma tag cadastrada
        if($tags->count() <= 0){
            $events =  Event::all();
            $data = ['msg' => "Não tem nenhuma tag cadastrada", 'data' => $events];
            return response()->json($data);
        }

        //pegando a data atual e passando para string
        $carbon =Carbon::now( 'America/Sao_Paulo')->toDateTimeString();

        //Pegando os eventos de acordo com a tag
        $events = DB::table('event_tag')->whereIn('tag_id', $tags)->pluck("event_id");
        $events = Event::whereIn('id', $events)->where('end_time','>',$carbon)->paginate(10);
        foreach ($events as $event) {
            $event->getStatus();
        }
        //Pegando os eventos confirmados
        $eventsConfirmed = $user->eventsConfirmed->pluck('id');

        //Checando se há alguma participação em evento está sem avaliação e sem confirmação de presença
        $eventsWithoutRate= $user->participationsWithoutRate->pluck('id');

        //checando se há algum evento na lista de eventos que eu selecionei que já finalizaram
        $eventsForPopup = DB::table('events')->whereIn('id',$eventsWithoutRate)->where('end_time','<',$carbon)->get();

    	$data = ["data" => ["eventsForHome" => $events, "eventsForPopUp" => $eventsForPopup, "eventsconfirmed"=> $eventsConfirmed]];
    	return response()->json($data);
    }

    public function experiences(Request $request){
        //return response()->json($request->filter, 200);
        $user = Auth::user();
        //pegando a data atual e passando para string
        $carbon =Carbon::now( 'America/Sao_Paulo')->toDateTimeString();

        switch ($request->filter) {
            case 'default':
                //pegando todos os eventos que tem a ver com minhas tags
                $tags = $user->tags->pluck("id");
                //checando se não há nenhuma tag cadastrada
                if($tags->count() <= 0){
                    $events = DB::table('events')->where('end_time','>',$carbon)->orderBy('start_time');
                }
                //Pegando os eventos de acordo com a tag
                $events = DB::table('event_tag')->whereIn('tag_id', $tags)->pluck("event_id");
                $events = Event::findMany($events)->where('end_time','>',$carbon);


                break;

            case 'going':
                //pegando os eventos confirmados
                $events = $user->eventsConfirmed()->get();
                break;

            case 'star':
                //pegando eventos com interesse
                $events = $user->eventsInteresed()->get();
                break;

            case 'created':
                //pegando evento criados por mim
                $events = $user->Myevents()->get();

                break;

            case 'all':
                //pegando todos os eventos
                $events = DB::table('events')->where('end_time','>',$carbon)->orderBy('start_time')->get();

                break;

            default:
                return response()->json(['msg' => 'Filtro não encontrado'], 400);
                break;
        }
        foreach ($events as $event) {
            $event->getStatus();
        }

         //Checando se há alguma participação em evento está sem avaliação e sem confirmação de presença
         $eventsWithoutRate= $user->participationsWithoutRate->pluck('id');
         //checando se há algum evento na lista de eventos que eu selecionei que já finalizaram
         $eventsForPopup = DB::table('events')->whereIn('id',$eventsWithoutRate)->where('end_time','<',$carbon)->get();

         $data = ["data" => ["eventsForHome" => $events, "eventsForPopUp" => $eventsForPopup]];
         return response()->json($data, 200);

    }
}


/**
 * @OA\Tag(
 *     name="home",
 *     description="Home",
 * )
 */

 /**
 * @OA\Get(
 *      path="/",
 *      operationId="home",
 *      tags={"home"},
 *      summary="Home",
 *      description="Home",
 *      @OA\Response(
 *          response=200,
 *          description="successful operation"
 *       ),
 *       @OA\Response(response=400, description="Bad request"),
 *     )
 *
 */
 /**
 * @OA\Get(
 *      path="/alta",
 *      tags={"home"},
 *      summary="Home",
 *      description="Return top events ",
 *      @OA\Response(
 *          response=200,
 *          description="successful operation"
 *       ),
 *       @OA\Response(response=400, description="Bad request"),
 *     )
 *
 */
 /**
 * @OA\Get(
 *      path="/proximas",
 *      tags={"home"},
 *      summary="Home",
 *      description="Return next Events",
 *      @OA\Response(
 *          response=200,
 *          description="successful operation"
 *       ),
 *       @OA\Response(response=400, description="Bad request"),
 *     )
 *
 */

/**
 * @OA\Tag(
 *     name="experiences",
 *     description="Experiences filters",
 * )
 */
 /**
 * @OA\Get(
 *      path="/experiences",
 *      operationId="experiences",
 *      tags={"experiences"},
 *      summary="Experiences filters",
 *      description="Filtrando as experiências através de um campo chamado filter que pode ser going, star, created e all",
 *      @OA\Parameter(
 *          name="filter",
 *          in="query",
 *          description="filters {going, star, created, all}",
 *          required=true,
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="successful operation"
 *       ),
 *       @OA\Response(response=400, description="Bad request"),
 *     )
 *
 */
