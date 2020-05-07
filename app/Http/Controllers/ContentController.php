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
 * @OA\Tag(
 *     name="reset_password",
 *     description="Reset Password routes",
 *     @OA\ExternalDocumentation(
 *         description="Find out more",
 *         url="http://swagger.io"
 *     )
 * )
 */

/**
 * @OA\Tag(
 *     name="content",
 *     description="All about contents",
 *     @OA\ExternalDocumentation(
 *         description="Find out more",
 *         url="http://swagger.io"
 *     )
 * )
 */

/**
 * @OA\Get(
 *      path="/content",
 *      operationId="get_content",
 *      tags={"content"},
 *      summary="Get Content",
 *      description="Returns list of contents",
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
 * Returns list of contents
 */

/**
 * @OA\Post(
 *      path="/content",
 *      operationId="post_content",
 *      tags={"content"},
 *      summary="Post de conteúdo",
 *      description="Cadastra um conteúdo",
 *     @OA\RequestBody(
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 @OA\Property(
 *                     property="title",
 *                     type="text"
 *                 ),
 *                 @OA\Property(
 *                     property="body",
 *                     type="text"
 *                 ),
 *                 @OA\Property(
 *                     property="link",
 *                     type="text"
 *                 ),
 *                 @OA\Property(
 *                     property="user_id",
 *                     type="integer"
 *                 ),
 *                 example={"title": "mamamia", "body":"blabal", "link":"", "user_id":1},
 *                 required={"title", "user_id"}
 *             )
 *         )
 *     ),
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
 */

/**
 * @OA\Put(
 *      path="/content/{id}",
 *      operationId="put_content",
 *      tags={"content"},
 *      summary="Put de conteúdo",
 *      description="Edita um conteúdo",
 *     @OA\RequestBody(
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 @OA\Property(
 *                     property="title",
 *                     type="text"
 *                 ),
 *                 @OA\Property(
 *                     property="body",
 *                     type="text"
 *                 ),
 *                 @OA\Property(
 *                     property="link",
 *                     type="text"
 *                 ),
 *                 @OA\Property(
 *                     property="user_id",
 *                     type="integer"
 *                 ),
 *                 example={"title": "mamamia", "body":"blabal", "link":"", "user_id":1},
 *                 required={"title", "user_id"}
 *             )
 *         )
 *     ),
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
 */

/**
 * @OA\Delete(
 *      path="/content/{id}",
 *      operationId="delete_content",
 *      tags={"content"},
 *      summary="Delete Content",
 *      description="Deleta um conteúdo",
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
 * Returns list of contents
 */

/**
 * @OA\Get(
 *      path="/password/find/{token}",
 *      operationId="check_token_password",
 *      tags={"reset_password"},
 *      summary="Check if exist token",
 *      description="Returns list of Communities",
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
 * Returns list of communities
 */

/**
 * @OA\Post(
 *      path="/password/create",
 *      operationId="reset_password_request",
 *      tags={"reset_password"},
 *      summary="Envia um email para resetar a senha",
 *      description="Envia um email para resetar a senha",
 *     @OA\RequestBody(
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 @OA\Property(
 *                     property="email",
 *                     type="text"
 *                 ),
 *                 example={"email": "teste@gmail.com"},
 *                 required={"email"}
 *             )
 *         )
 *     ),
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
 */

/**
 * @OA\Post(
 *      path="/password/reset",
 *      operationId="reset_password",
 *      tags={"reset_password"},
 *      summary="Form reset password",
 *      description="Formulário de resetar a senha",
 *     @OA\RequestBody(
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 @OA\Property(
 *                     property="email",
 *                     type="text"
 *                 ),
 *                 @OA\Property(
 *                     property="token",
 *                     type="text"
 *                 ),
 *                 @OA\Property(
 *                     property="password",
 *                     type="text"
 *                 ),
 *                 @OA\Property(
 *                     property="password_confirmation",
 *                     type="text"
 *                 ),
 *                 example={"email": "wesleymotabr@gmail.com","token": "2UOdHfRrCp2qzHIy8eI15C6T2IR4Q9VgXkgOBqyARmnhzfKxD1T9rNaJXKLq","password": "secret","password_confirmation": "secret"},
 *                 required={"email", "token", "password", "password_confirmation"}
 *             )
 *         )
 *     ),
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

 */

