<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Tag;
use App\Event;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Auth;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
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
        $events = Event::findMany($events)->where('end_time','>',$carbon);
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

    public function experiences($filter){
        $user = Auth::user();
        //pegando a data atual e passando para string
        $carbon =Carbon::now( 'America/Sao_Paulo')->toDateTimeString();

        switch ($filter) {
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
                $events = $user->eventsConfirmed();
                break;

            case 'star':
                //pegando eventos com interesse
                $events = $user->eventsInteresed();
                break;

            case 'created':
                //pegando evento criados por mim
                $events = $user->eventsByMe();
                break;

            case 'all':
                //pegando todos os eventos
                $events = DB::table('events')->where('end_time','>',$carbon)->orderBy('start_time')->get();

                break;

            default:
                return response()->json(['msg' => 'Filtro não encontrado'], 400);
                break;
        }
         //Pegando os eventos confirmados
         $eventsConfirmed = $user->eventsConfirmed->pluck('id');

         //Checando se há alguma participação em evento está sem avaliação e sem confirmação de presença
         $eventsWithoutRate= $user->participationsWithoutRate->pluck('id');

         //checando se há algum evento na lista de eventos que eu selecionei que já finalizaram
         $eventsForPopup = DB::table('events')->whereIn('id',$eventsWithoutRate)->where('end_time','<',$carbon)->get();
         $data = ["data" => ["eventsForHome" => $events, "eventsForPopUp" => $eventsForPopup, "eventsconfirmed"=> $eventsConfirmed]];
         return response()->json($data, 200);

    }
}
