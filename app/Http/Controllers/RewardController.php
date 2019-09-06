<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Reward;

class RewardController extends Controller
{
    public function index(){
        $data = Reward::all();
    	if($data->count() == 0){
        
            return response()->json(['msg' => 'Não há registro de Reward'], 404);
        
        }
    	return response()->json(['data' => $data], 201);
    }

    public function show($id){
        $data = Reward::find($id);
    	if(!$data){
        
            return response()->json(['msg' => 'reward não encontrado'], 404);
        
        }
    	return response()->json(['data' => $data], 201);
    }

    public function store(Request $request){
        $reward = new Reward;
        
    	$reward->create($request->all());	
    	
    	return response()->json(['msg' => 'Reward cadastrada com sucesso!'], 201);
    }


    public function update(Request $request, $id){
        
        $reward = Reward::find($id);
        
        if(! $reward){
        
            return response()->json(['msg' => 'reward não encontrado'], 404);
        
        }

    	$reward->update($request->all());
  	
    	return response()->json(['msg' => 'reward editada com sucesso!'], 201);	
    }

    public function delete($id){
        $reward = Reward::find($id);
    		if(! $reward){
                return response()->json(['msg' => 'Reward não encontrado'], 404);
            } 
	    	$reward->delete();
	    	
	    	return response()->json(['msg' => 'Reward deletada com sucesso!'], 201);
    }
}
