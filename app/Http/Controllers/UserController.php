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

    public function show(User $id){
        $tags = $id->tags;

        $data = ['data' => ['user' => $id]];
        return response()->json($data);
    }
/*
    public function store(Request $request){
        $user = new User;
        $user->createUser($request);
    	return response()->json(['msg' => 'Usuário cadastrada com sucesso!'], 201);

    } */

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
                }else{
                    $tag_component = new Tag;
                    $tag_component->createMassive($tag);
                    $tag_component->users()->sync($id);
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

    public function journey(){
        $user = User::find(1);
        $journey = $user->myJourney;
        return response()->json($journey, 200);
    }

}

//Api Documentation

/**
 * @OA\Tag(
 *     name="users",
 *     description="Everything about your users",
 *     @OA\ExternalDocumentation(
 *         description="Find out more",
 *         url="http://swagger.io"
 *     )
 * )
 */


 /**
 * @OA\Get(
 *      path="/users",
 *      operationId="getusers",
 *      tags={"users"},
 *      summary="Get list of users",
 *      description="Returns list of Users",
 *      @OA\Response(
 *          response=200,
 *          description="successful operation"
 *       ),
 *       @OA\Response(response=400, description="Bad request"),
 *       security={
 *           {"api_key_security_example": {}}
 *       }
 *     )
 *
 * Returns list of users
 */
   /**
 * @OA\Put(
 *      path="/users/{id}",
 *      operationId="update_user",
 *      tags={"users"},
 *      summary="Edit an user",
 *      description="Returns list of users",
 *      @OA\Response(
 *          response=200,
 *          description="successful operation"
 *       ),
 *       @OA\Response(response=400, description="Bad request"),
 *
 *     )
 *
 * Return an user Edited
 */
   /**
 * @OA\Get(
 *      path="/users/{id}",
 *      operationId="single_user",
 *      tags={"users"},
 *      summary="Get an user",
 *      description="Returns list of users",
 *      @OA\Response(
 *          response=200,
 *          description="successful operation"
 *       ),
 *       @OA\Response(response=400, description="Bad request"),
 *
 *     )
 *
 * Return an user
 */

 /**
 * @OA\Post(
 *      path="/users",
 *      operationId="add_user",
 *      tags={"users"},
 *      summary="Add an user",
 *      description="Returns list of users",
 *      @OA\Response(
 *          response=200,
 *          description="successful operation"
 *       ),
 *       @OA\Response(response=400, description="Bad request"),
 *       security={
 *           {"api_key_security_example": {}}
 *       }
 *     )
 *
 * Returns list of users
 */

 /**
 * @OA\Delete(
 *      path="/users/{id}",
 *      operationId="delete_user",
 *      tags={"users"},
 *      summary="Delete an user",
 *      description="Returns list of users",
 *      @OA\Response(
 *          response=200,
 *          description="successful operation"
 *       ),
 *       @OA\Response(response=400, description="Bad request"),
 *
 *     )
 *
 * Return a message of sucess
 */


/**
 * @OA\Tag(
 *     name="home",
 *     description="Home",
 * )
 */

 /**
 * @OA\Get(
 *      path="/home/{id}",
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
