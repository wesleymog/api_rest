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
 * @SWG\Tag(
 *     name="Invitations",
 *     description="Everything about your Invitation",
 *     @SWG\ExternalDocumentation(
 *         description="Find out more",
 *         url="http://swagger.io"
 *     )
 * )
 */
/**
 * @SWG\Post(
 *      path="/invitation",
 *      operationId="add_invitation",
 *      tags={"Invitations"},
 *      summary="Adiciona um novo convite para um usuário em um evento",
 *      description="Receiver é o convidado do evento",
 *     @SWG\RequestBody(
 *         @SWG\MediaType(
 *             mediaType="application/json",
 *             @SWG\Schema(
 *                 @SWG\Property(
 *                     property="receiver_id",
 *                     type="integer"
 *                 ),
 *                 @SWG\Property(
 *                     property="event_id",
 *                     type="integer"
 *                 ),
 *                 example={"receiver_id": 10, "event_id": 10},
 *                 required={"receiver_id","event_id"}
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
 * @SWG\Get(
 *      path="/myInvitations",
 *      operationId="get_user_invitations",
 *      tags={"Invitations"},
 *      summary="Retorna os convites do usuário logado",
 *      description="",
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
 * @SWG\Get(
 *      path="/invitation/event/{id}",
 *      operationId="get_invitations_by_event",
 *      tags={"Invitations"},
 *      summary="Retorna os convites de acordo com o id do evento",
 *      description="",
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
