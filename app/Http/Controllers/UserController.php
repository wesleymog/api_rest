<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Tag;
use App\Event;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(){
    	$data = ['data' => User::all()];
    	
    	return response()->json($data);
    }

    public function home($id){
        
        $user = User::find($id);
        
        $tags = $user->tags->pluck("user");
        //checando se não há nenhuma tag cadastrada
        if($tags->count() <= 0){
            $events =  Event::all();
            $data = ['msg' => "Não tem nenhuma tag cadastrada", 'data' => $events];
            return response()->json($data);
        }

        //Pegando os eventos de acordo com a tag
        $results = DB::table('event_tag')->where('tag_id', $tags)->pluck("event_id");
        $events = [];
        foreach($results as $result){
            $result_temp = Event::find($result);
            array_push($events, $result_temp);
        }

        //Checando se há alguma participação em evento está sem avaliação e sem confirmação de presença
        $eventsWithoutRate = DB::table('participations')->where('user_id',$id)->where('rate',null)->where('status',null)->pluck('event_id');
        
        //pegando a data atual e passando para string
        $carbon =Carbon::now( 'America/Sao_Paulo')->toDateTimeString();

        //checando se há algum evento na lista de eventos que eu selecionei que já finalizaram
        $eventsForPopup = DB::table('events')->whereIn('id', $eventsWithoutRate)->where('end_time','<',$carbon)->get();
        
    	$data = ["data" => ["eventsForHome" => $events, "eventsForPopUp" => $eventsForPopup]];
    	return response()->json($data);
    }

    public function show(User $id){
        $tags = $id->tags;

        $data = ['data' => ['user' => $id]];
        return response()->json($data);
    }

    public function store(Request $request){
        $user = new User;
        $user->createUser($request);
    	return response()->json(['msg' => 'Usuário cadastrada com sucesso!'], 201);

    }

    public function update(Request $request, $id){
        $UserData = $request->all();
        $user = User::find($id);
        if(! $user) return response()->json(['msg' => 'Usuario não encontrado'], 404);
        $user->update($UserData);
        
        //Tratamento das Tags
        if($tags = explode(",", $request->tags)){
            foreach ($tags as $tag) {
                if($tag_component = Tag::find($tag)){
                    $tag_component->users()->attach($user);
                }
            }   
        }
          

        return response()->json(['msg' => 'Usuário Atualizado com sucesso!'], 201);


    }
    public function delete($id){
        try {
            $user = User::find($id);
            if(! $user) return response()->json(['msg' => 'User não encontrado'], 404);
            $user->delete();
            
            return response()->json(['msg' => 'User deletada com sucesso!'], 201);
            
        } catch (\Exception $e) {
            
            return response()->json(['msg' => 'Houve um erro na hora de deletar!'], 500);
            
        }

    }
}
