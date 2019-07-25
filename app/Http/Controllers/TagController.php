<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tag;

class TagController extends Controller
{
    public function index(){
    	$data = ['data' => Tag::all()];
    	
    	return response()->json($data);
    }

    public function show(Tag $id){
    	$data = ['data' => $id];
    	
    	return response()->json($data);
    }

    public function store(Request $request){
    	$TagData = $request->all();
    	$tag = new Tag;
    	$tag->create($TagData);	
    	
    	return response()->json(['msg' => 'Tag cadastrada com sucesso!'], 201);

    }

    public function update(Request $request, $id){
    	$TagData = $request->all();
    	$tag = Tag::find($id);
    	if(! $tag) return response()->json(['msg' => 'Tag não encontrado'], 404);
    	$tag->update($TagData);
  	
    	return response()->json(['msg' => 'Tag editada com sucesso!'], 201);	
    }

    public function delete($id){
    	try {
    		$tag = Tag::find($id);
    		if(! $tag) return response()->json(['msg' => 'Tag não encontrado'], 404);
	    	$tag->delete();
	    	
	    	return response()->json(['msg' => 'Tag deletada com sucesso!'], 201);
    		
    	} catch (\Exception $e) {
	    	
	    	return response()->json(['msg' => 'Houve um erro na hora de deletar!'], 500);
    		
    	}

    }
}
