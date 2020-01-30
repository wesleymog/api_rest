<?php

namespace App\Http\Controllers;

use App\Invitation;
use Illuminate\Http\Request;

class InvitationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $invitation = new Invitation;
        $invitation->makeInvitation($request);

        return response()->json(['msg' => 'Invitation realizada com sucesso', 'data' => $invitation], 201);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Invitation  $invitation
     * @return \Illuminate\Http\Response
     */
    public function show(Invitation $invitation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Invitation  $invitation
     * @return \Illuminate\Http\Response
     */
    public function edit(Invitation $invitation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Invitation  $invitation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Invitation $invitation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Invitation  $invitation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invitation $invitation)
    {
        //
    }
}

// Documentação API

/**
 * @OA\Tag(
 *     name="Invitations",
 *     description="Everything about your Invitation",
 *     @OA\ExternalDocumentation(
 *         description="Find out more",
 *         url="http://swagger.io"
 *     )
 * )
 */
/**
 * @OA\Post(
 *      path="/invitation",
 *      operationId="add_invitation",
 *      tags={"Invitations"},
 *      summary="Adiciona um novo convite para um usuário em um evento",
 *      description="Modelo de JSON: {'receiver_id': 9,'event_id': 7}. Onde receiver é o usuário que vai ser convidado",
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
 * @OA\Get(
 *      path="/myInvitations",
 *      operationId="get_user_invitations",
 *      tags={"Invitations"},
 *      summary="Retorna os convites do usuário logado",
 *      description="",
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
 * @OA\Get(
 *      path="/invitation/event/{id}",
 *      operationId="get_invitations_by_event",
 *      tags={"Invitations"},
 *      summary="Retorna os convites de acordo com o id do evento",
 *      description="",
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
