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

    public function show(Event $id){
    	$tags = $id->tags->pluck('id');
        
    	return response()->json($tags);
    }

    public function store(Request $request){
    	$EventData = $request->all();
    	$event = Event::create($EventData);    
    	//Tratamento das Tags
        if($tags = explode(",", $request->tags)){
            foreach ($tags as $tag) {
                if($tag_component = Tag::find($tag)){
                    $tag_component->events()->attach($event);
                }
            }   
        }
          
    	return response()->json(['msg' => 'Evento cadastrado com sucesso!'], 201);

    }

    public function update(Request $request, $id){
        $EventData = $request->all();
        $event = Event::find($id);
        if(! $event) return response()->json(['msg' => 'Evento não encontrado'], 404);
        $event->update($EventData);
        
        //Tratamento das Tags
        if($tags = explode(",", $request->tags)){
            foreach ($tags as $tag) {
                if($tag_component = Tag::find($tag)){
                    $tag_component->event()->attach($event);
                }
            }   
        }
          

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
