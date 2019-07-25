<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Tag;

use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(){
    	$data = ['data' => User::all()];
    	
    	return response()->json($data);
    }

    public function show(User $id){
    	$data = ['data' => $id];
    	
    	return response()->json($data);
    }

    public function store(Request $request){
    	$UserData = $request->all();
        $UserData['password'] = Hash::make($request['password']);
    	$user = new User;
    	$user->create($UserData);
    	
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
