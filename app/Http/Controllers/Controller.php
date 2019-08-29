<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}


/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="L5 OpenApi",
 *      description="L5 Swagger OpenApi description",
 *      @OA\Contact(
 *          email="darius@matulionis.lt"
 *      ),
 *     @OA\License(
 *         name="Apache 2.0",
 *         url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *     )
 * )
 */
/**
 *  @OA\Server(
 *      url=L5_SWAGGER_CONST_HOST,
 *      description="L5 Swagger OpenApi dynamic host server"
 *  )
 *
 *  @OA\Server(
*      url="https://localhost:8000/api/",
 *      description="L5 Swagger OpenApi Server"
 * )
 */

/**
 * @OA\Tag(
 *     name="Events",
 *     description="Everything about your Events",
 *     @OA\ExternalDocumentation(
 *         description="Find out more",
 *         url="http://swagger.io"
 *     )
 * )
 */

 /**
 * @OA\Get(
 *      path="/events",
 *      operationId="getEvents",
 *      tags={"Events"},
 *      summary="Get list of Events",
 *      description="Returns list of Evennts",
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
 * Returns list of Events
 */
   /**
 * @OA\Put(
 *      path="/events/{id}",
 *      operationId="update_event",
 *      tags={"Events"},
 *      summary="Edit an Event",
 *      description="Returns list of Events",
 *      @OA\Response(
 *          response=200,
 *          description="successful operation"
 *       ),
 *       @OA\Response(response=400, description="Bad request"),
 *       
 *     )
 *
 * Return an Event Edited
 */
   /**
 * @OA\Get(
 *      path="/events/{id}",
 *      operationId="single_event",
 *      tags={"Events"},
 *      summary="Get an Event",
 *      description="Returns list of Events",
 *      @OA\Response(
 *          response=200,
 *          description="successful operation"
 *       ),
 *       @OA\Response(response=400, description="Bad request"),
 *       
 *     )
 *
 * Return an Event
 */

 /**
 * @OA\Post(
 *      path="/events",
 *      operationId="add_event",
 *      tags={"Events"},
 *      summary="Add an Event",
 *      description="Returns list of Events",
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
 * Returns list of Events
 */

 /**
 * @OA\Delete(
 *      path="/events/{id}",
 *      operationId="delete_event",
 *      tags={"Events"},
 *      summary="Delete an Event",
 *      description="Returns list of Events",
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
 *     name="tags",
 *     description="Everything about your tags",
 *     @OA\ExternalDocumentation(
 *         description="Find out more",
 *         url="http://swagger.io"
 *     )
 * )
 */

 /**
 * @OA\Get(
 *      path="/tags",
 *      operationId="gettags",
 *      tags={"tags"},
 *      summary="Get list of tags",
 *      description="Returns list of tags",
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
 * Returns list of tags
 */
   /**
 * @OA\Put(
 *      path="/tags/{id}",
 *      operationId="update_tag",
 *      tags={"tags"},
 *      summary="Edit an tag",
 *      description="Returns list of tags",
 *      @OA\Response(
 *          response=200,
 *          description="successful operation"
 *       ),
 *       @OA\Response(response=400, description="Bad request"),
 *       
 *     )
 *
 * Return an tag Edited
 */
   /**
 * @OA\Get(
 *      path="/tags/{id}",
 *      operationId="single_tag",
 *      tags={"tags"},
 *      summary="Get an tag",
 *      description="Returns list of tags",
 *      @OA\Response(
 *          response=200,
 *          description="successful operation"
 *       ),
 *       @OA\Response(response=400, description="Bad request"),
 *       
 *     )
 *
 * Return an tag
 */

 /**
 * @OA\Post(
 *      path="/tags",
 *      operationId="add_tag",
 *      tags={"tags"},
 *      summary="Add an tag",
 *      description="Returns list of tags",
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
 * Returns list of tags
 */

 /**
 * @OA\Delete(
 *      path="/tags/{id}",
 *      operationId="delete_tag",
 *      tags={"tags"},
 *      summary="Delete an tag",
 *      description="Returns list of tags",
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




