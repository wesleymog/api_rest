<?php

namespace App\Http\Controllers;

use App\Content;
use Illuminate\Http\Request;

class ContentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(["data"=>["contents"=> Content::all()]], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->link != null || $request->body != null ){
            $content = new Content;
            $content->createContent($request);
            return response()->json(["data"=>["msg"=>"Content create successful!", "content" => $content]], 200);
        }else{
            return response()->json(["msg"=>"Body and Link is empty!"], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Content  $content
     * @return \Illuminate\Http\Response
     */
    public function show(Content $content)
    {
        return response()->json(["data"=>["content"=>$content]], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Content  $content
     * @return \Illuminate\Http\Response
     */
    public function edit(Content $content)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Content  $content
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Content $content)
    {
        $content = Content::find($id);
        if(! $content) return response()->json(['msg' => 'Content not found'], 404);
        $content->updateContent($request);

        return response()->json(['data'=>["msg"=>"Content updated successful","content"=>$content]], 201);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Content  $content
     * @return \Illuminate\Http\Response
     */
    public function destroy(Content $content)
    {
            $content->delete();
            return response()->json(["data"=>["msg"=>"deleted successful"]], 200);

    }
}

// Documentação API

/**
 * @SWG\Tag(
 *     name="reset_password",
 *     description="Reset Password routes",
 *     @SWG\ExternalDocumentation(
 *         description="Find out more",
 *         url="http://swagger.io"
 *     )
 * )
 */
/**
 * @SWG\Get(
 *      path="/password/find/{token}",
 *      operationId="check_token_password",
 *      tags={"reset_password"},
 *      summary="Check if exist token",
 *      description="Returns list of Communities",
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
 * Returns list of communities
 */

/**
 * @SWG\Post(
 *      path="/password/create",
 *      operationId="reset_password_request",
 *      tags={"reset_password"},
 *      summary="Envia um email para resetar a senha",
 *      description="Envia um email para resetar a senha",
 *     @SWG\RequestBody(
 *         @SWG\MediaType(
 *             mediaType="application/json",
 *             @SWG\Schema(
 *                 @SWG\Property(
 *                     property="email",
 *                     type="text"
 *                 ),
 *                 example={"email": "teste@gmail.com"},
 *                 required={"email"}
 *             )
 *         )
 *     ),
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
 */

/**
 * @SWG\Post(
 *      path="/password/reset",
 *      operationId="reset_password",
 *      tags={"reset_password"},
 *      summary="Form reset password",
 *      description="Formulário de resetar a senha",
 *     @SWG\RequestBody(
 *         @SWG\MediaType(
 *             mediaType="application/json",
 *             @SWG\Schema(
 *                 @SWG\Property(
 *                     property="email",
 *                     type="text"
 *                 ),
 *                 @SWG\Property(
 *                     property="token",
 *                     type="text"
 *                 ),
 *                 @SWG\Property(
 *                     property="password",
 *                     type="text"
 *                 ),
 *                 @SWG\Property(
 *                     property="password_confirmation",
 *                     type="text"
 *                 ),
 *                 example={"email": "wesleymotabr@gmail.com","token": "2UOdHfRrCp2qzHIy8eI15C6T2IR4Q9VgXkgOBqyARmnhzfKxD1T9rNaJXKLq","password": "secret","password_confirmation": "secret"},
 *                 required={"email", "token", "password", "password_confirmation"}
 *             )
 *         )
 *     ),
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

 */

