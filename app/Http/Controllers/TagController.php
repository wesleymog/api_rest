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
    public function autocomplete(Request $request){
        if($request->max) $max = $request->max;
        else $max = 5;

        $data = Tag::select("name")
                ->where("name","LIKE","%{$request->name}%")
                ->take($max)
                ->get();
        return response()->json($data);
    }
}
//Api Documentation
/**
 * @SWG\Tag(
 *     name="tags",
 *     description="Everything about your tags",
 *     @SWG\ExternalDocumentation(
 *         description="Find out more",
 *         url="http://swagger.io"
 *     )
 * )
 */

 /**
 * @SWG\Get(
 *      path="/tags",
 *      operationId="gettags",
 *      tags={"tags"},
 *      summary="Get list of tags",
 *      description="Returns list of tags",
 *      @SWG\Response(
 *          response=200,
 *          description="successful operation"
 *       ),
 *       @SWG\Response(response=400, description="Bad request"),
 *       security={
 *           {"api_key_security_example": {}}
 *       }
 *     )
 *
 * Returns list of tags
 */
   /**
 * @SWG\Put(
 *      path="/tags/{id}",
 *      operationId="update_tag",
 *      tags={"tags"},
 *      summary="Edit an tag",
 *      description="Returns list of tags",
 *      @SWG\Response(
 *          response=200,
 *          description="successful operation"
 *       ),
 *       @SWG\Response(response=400, description="Bad request"),
 *
 *     )
 *
 * Return an tag Edited
 */
   /**
 * @SWG\Get(
 *      path="/tags/{id}",
 *      operationId="single_tag",
 *      tags={"tags"},
 *      summary="Get an tag",
 *      description="Returns list of tags",
 *      @SWG\Response(
 *          response=200,
 *          description="successful operation"
 *       ),
 *       @SWG\Response(response=400, description="Bad request"),
 *
 *     )
 *
 * Return an tag
 */

 /**
 * @SWG\Post(
 *      path="/tags",
 *      operationId="add_tag",
 *      tags={"tags"},
 *      summary="Add an tag",
 *      description="Returns list of tags",
 *      @SWG\Response(
 *          response=200,
 *          description="successful operation"
 *       ),
 *       @SWG\Response(response=400, description="Bad request"),
 *       security={
 *           {"api_key_security_example": {}}
 *       }
 *     )
 *
 * Returns list of tags
 */

 /**
 * @SWG\Delete(
 *      path="/tags/{id}",
 *      operationId="delete_tag",
 *      tags={"tags"},
 *      summary="Delete an tag",
 *      description="Returns list of tags",
 *      @SWG\Response(
 *          response=200,
 *          description="successful operation"
 *       ),
 *       @SWG\Response(response=400, description="Bad request"),
 *
 *     )
 *
 * Return a message of sucess
 */
/*
    paths:
      /events/{id}:
        get:
          parameters:
            - in: path
              name: id   # Note the name is the same as in the path
              required: true
              schema:
                type: integer
                minimum: 1
              description: The user ID
*/
