<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Event;
use App\Notification;
class NotificationController extends Controller
{
    public function index(){
        $user = Auth::user();
        $parts = $user->participationsWithoutRate;
        foreach ($parts as $part) {
            return response()->json($parts, 500);
            if($part->notifications->isEmpty()){
                Notification::createMassive($part);
            }
        }
        $notifications = $user->notifications;

        //pegando a data com mais um dia
        $carbon =Carbon::now( 'America/Sao_Paulo')->add(1, 'day')->toDateTimeString();

        //Deletando notifications antigos
        foreach ($notifications as $notification) {
            $notification->event_id = Event::find($notification->event_id);
            if($notification->event_id->end_time > $carbon && $notification->type == 1){
                $notification->delete();
            }
        }
        $notifications = $notifications->sortByDesc('created_at')->values();


        return response()->json(['notifications'=>$notifications, 'user'=>$user], 200);
    }

    public function delete($id){

        $notification = Notification::find($id);
        if(! $notification) return response()->json(['msg' => 'Notificação não encontrada'], 404);
        $notification->delete();

        return response()->json(['msg' => 'Notificação deletada com sucesso!'], 201);
    }
    public function markAsRead($id){
        $notification = Notification::find($id);

        if(! $notification) return response()->json(['msg' => 'Notificação não encontrada'], 404);

        $notification->markAsRead();
        return response()->json(['msg'=> 'Notificação marcada como lida'], 200);
    }
}
/**
 * @OA\Tag(
 *     name="notifications",
 *     description="notifications",
 * )
 */
/**
 * @OA\Get(
 *      path="/notifications/",
 *      operationId="notifications",
 *      tags={"notifications"},
 *      summary="Notifications",
 *      description="Retornando as notificações do usuério e removendo os convites desatualizados, ordenados pela ordem de criação",
 *      @OA\Response(
 *          response=200,
 *          description="successful operation",
 *          @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 @OA\Property(
 *                     property="notifications",
 *                     type="array",
 *                      @OA\Items(
 *                          @OA\Property(property="id",type="integer"),
 *                          @OA\Property(property="type",type="integer"),
 *                          @OA\Property(property="user_id",type="integer"),
 *                          @OA\Property(property="read",type="boolean"),
 *
 *                          @OA\Property(
 *                              property="event_id",
 *                              type="array",
 *
 *                              @OA\Items(
 *                                  @OA\Property(property="type",type="integer"),
 *                                  @OA\Property(property="title",type="string"),
 *                                  @OA\Property(property="code",type="string"),
 *                                  @OA\Property(property="category",type="string"),
 *                                  @OA\Property(property="start_time",type="datetime"),
 *                                  @OA\Property(property="end_time",type="datetime"),
 *                                  @OA\Property(property="location",type="string"),
 *                                  @OA\Property(property="description",type="string"),
 *                                  @OA\Property(property="img",type="string"),
 *                                  @OA\Property(property="value",type="double"),
 *                                  @OA\Property(property="user_id",type="integer"),
 *                                  @OA\Property(property="tags",type="string"),
 *                                  @OA\Property(property="recurrence",type="string"),
 *                                  )
 *                              ),
 *
 *                      )
 *                 ),
 *                 example={ "notifications": { { "id": 2, "user_id": 1, "event_id": { "id": 7, "type": 1, "category": "teste", "title": " LUNCH ‘N’ LEARN – MERO 2", "code": "#1", "start_time": "2020-03-03 17:58:25", "end_time": "2020-03-04 19:58:25", "location": "SALA 2", "description": "", "recurrence": "none", "img": "1", "value": 10, "user_id": 1, "event_id": null, "boost": 0, "created_at": null, "updated_at": null }, "type": 2, "read": 0, "created_at": "2020-03-06 21:00:36", "updated_at": "2020-03-06 21:00:36" }, { "id": 1, "user_id": 1, "event_id": { "id": 15, "type": 1, "category": "1", "title": "sasaasa", "code": "#a101", "start_time": "2019-12-28 20:45:12", "end_time": "2019-08-30 23:05:12", "location": "Carrin", "description": "legal", "recurrence": "none", "img": null, "value": 10, "user_id": 1, "event_id": null, "boost": 0, "created_at": "2020-03-06 20:59:04", "updated_at": "2020-03-06 20:59:04" }, "type": 1, "read": 0, "created_at": "2020-03-06 20:59:04", "updated_at": "2020-03-06 20:59:04" } } }
 *             )
 *         )
 *       ),
 *       @OA\Response(response=400, description="Bad request"),
 *     )
 *
 */

 /**
 * @OA\Put(
 *      path="/notifications/markAsRead/{id}",
 *      operationId="notification_markAsRead",
 *      tags={"Notifications"},
 *      summary="Marca como lida uma notificação",
 *      description="Marca como lida uma notificação",
 *      @OA\Response(
 *          response=200,
 *          description="successful operation"
 *       ),
 *       @OA\Response(response=400, description="Bad request"),
 *       @OA\Response(response=404, description="Notificação não encontrada"),
 *
 *     )
 *
 * Return a message of success
 */
 /**
 * @OA\Delete(
 *      path="/notifications/{id}",
 *      operationId="notification_delete",
 *      tags={"Notifications"},
 *      summary="Deleta uma notificação",
 *      description="Remove uma notificação com o id enviado",
 *      @OA\Response(
 *          response=200,
 *          description="successful operation"
 *       ),
 *       @OA\Response(response=400, description="Bad request"),
 *       @OA\Response(response=404, description="Notificação não encontrada"),
 *
 *     )
 *
 * Return a message of success
 */
