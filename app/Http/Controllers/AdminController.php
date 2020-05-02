<?php

namespace App\Http\Controllers;

use App\Admin;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use App\Event;
use Illuminate\Support\Facades\DB;
use App\Tag;
use App\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admin = new Admin();
        $data = [
            'tags_eventos'=>$admin->BestTagsInitiatives(),
            'tags_user'=> $admin->BestTagsUsers(),
            'events_user'=>$admin->MostConfirmedInitiatives(),
            'count_event'=>$admin->CountEventsByMonth()
        ];
        return response()->json($data, 200);
    }
    public function index1(){
        return 'oi';
    }

    public function dashboard(Request $request){
        $type = $request->type;
        $filters = $request->filters;

        //CHECANDO SE HÁ START_TIME E END_TIME
        if(!(array_key_exists("start_time", $filters))){
            $filters['start_time'] = "2019-03-11 21:55:38";
        }

        if(!(array_key_exists("end_time", $filters))){
            $filters['end_time'] = new Carbon('now');
        }

        //CONFIGURANDO ARRAY DE SEMANAS
        $start_day = Carbon::parse($filters['start_time']);
        $firstdayWeek = Carbon::parse($filters['start_time'])->startOfWeek();
        if($firstdayWeek->lessThan($start_day)){
            $firstDay = $start_day;
            $firstdayWeek->addWeek();
        }else{
            $firstDay = null;
        }

        $period = CarbonPeriod::since($firstdayWeek)->days(7)->until($filters['end_time'])->toArray();

        $response = collect();

        //PARTICIPATION = MÉTRICA DE PARTICIPAÇÃO
        if($type == 'participation'){
            if($firstDay != null){
                $events = Event::where('end_time','>' ,$start_day->toDateTimeString())->where('end_time','<' ,$firstdayWeek->toDateTimeString())->get();
                $participations = 0;
                $suggested = 0;
                $notifications = 0;
                foreach ($events as $event) {
                    $participations += $event->participations()->count();
                    $suggested += $event->suggested()->count();
                    $notifications += $event->notifications()->count();
                }

                if($suggested + $notifications != 0){
                    $indicator = $participations/($suggested+$notifications);
                }else{
                    $indicator = 0;
                }
                $response->add(['indicator'=>$indicator,'period'=>$start_day->toDateTimeString()]);
            }
            foreach ($period as $day) {
                $events = Event::where('end_time','>' ,$day->toDateTimeString())->where('end_time','<' ,$day->addWeek()->toDateTimeString())->get();
                $participations = 0;
                $suggested = 0;
                $notifications = 0;
                foreach ($events as $event) {
                    $participations += $event->participations()->count();
                    $suggested += $event->suggested()->count();
                    $notifications += $event->notifications()->count();
                }

                if($suggested + $notifications != 0){
                    $indicator = $participations/($suggested+$notifications);
                }else{
                    $indicator = 0;
                }

                $response->add(['indicator'=>$indicator,'period'=>$day->subWeek()->toDateTimeString()]);
            }
            return response()->json(['data'=>$response], 200);

        }
        //EVALUATION = MÉTRICA DE AVALIAÇÃO
        elseif ($type == 'evaluation') {

            if((array_key_exists("event_id", $filters))){

                $event = Event::find($filters['event_id']);
                $indicator = DB::table('participations')->where('status', true)->avg('rate');
                return response()->json(['indicator' => $indicator], 200);

            }
            foreach ($period as $day) {
                $events = Event::where('end_time','>' ,$day->toDateTimeString())->where('end_time','<' ,$day->addWeek()->toDateTimeString())->pluck('id');
                $indicator = DB::table('participations')->whereIn('event_id',$events)->avg('rate');
                $response->add(['indicator'=>$indicator,'period'=>$day->subWeek()->toDateTimeString()]);
            }

            return response()->json(['data' => $response], 200);

        }

        //Nº de iniciativas criada
        elseif($type == 'initiativeCreated'){
            foreach ($period as $day) {
                $indicator = Event::where('end_time','>' ,$day->toDateTimeString())->where('end_time','<' ,$day->addWeek()->toDateTimeString())->count();
                $response->add(['indicator'=>$indicator,'period'=>$day->subWeek()->toDateTimeString()]);
            }
            return response()->json(['data' => $response], 200);

        }elseif($type == 'initiativeCreatedByType'){
            foreach ($period as $day) {
                $indicator = Event::where('type', $filters['type'])->where('end_time','>' ,$day->toDateTimeString())->where('end_time','<' ,$day->addWeek()->toDateTimeString())->count();
                $response->add(['indicator'=>$indicator,'period'=>$day->subWeek()->toDateTimeString()]);
            }
            return response()->json(['data' => $response], 200);

        }elseif($type == 'initiativeCreatedByTags'){

            if($tag = Tag::find($filters['tag']));
            elseif($tag = DB::table('tags')->where("name",$filters['tag'])->first()){
                $tag = Tag::find($tag->id);
            }
            foreach ($period as $day) {
                $eventcount = $tag->events->where('type', $filters['type'])->where('end_time','>' ,$day->toDateTimeString())->where('end_time','<' ,$day->addWeek()->toDateTimeString())->count();
                $response->add(['indicator'=>$indicator,'period'=>$day->subWeek()->toDateTimeString()]);
            }

            return response()->json(['data' => $response], 200);

        }elseif($type == 'interests'){
            $users = User::all()->pluck("id");
            $tags = DB::table('tag_user')
                 ->where('category', 'interests')
                 ->whereIn('user_id', $users)
                 ->select('tag_id', DB::raw('count(*) as total'))
                 ->groupBy('tag_id')
                 ->get();
            $tags = $tags->sortByDesc('total')->values();
            foreach ($tags as $tag) {
                $tag->tag_id = Tag::find($tag->tag_id);
            }
            return response()->json(['interests', $tags], 200);

        }elseif($type == 'skills'){

            $users = User::all()->pluck("id");
            $tags = DB::table('tag_user')
                 ->where('category', 'skills')
                 ->whereIn('user_id', $users)
                 ->select('tag_id', DB::raw('count(*) as total'))
                 ->groupBy('tag_id')
                 ->get();
            $tags = $tags->sortByDesc('total')->values();
            foreach ($tags as $tag) {
                $tag->tag_id = Tag::find($tag->tag_id);
            }
            return response()->json(['skills', $tags], 200);
        }
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
     * Store a newly InitiativeCreated resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function show(Admin $admin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function edit(Admin $admin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Admin $admin)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function destroy(Admin $admin)
    {
        //
    }
}
// Documentação API

/**
 * @SWG\Tag(
 *     name="Admin",
 *     description="Admin routes",
 *     @SWG\ExternalDocumentation(
 *         description="Find out more",
 *         url="http://swagger.io"
 *     )
 * )
 */

  /**
 * @SWG\Post(
 *      path="/admin/dashboard",
 *      operationId="dashboard",
 *      tags={"Admin"},
 *      summary="Para gerar os dados necessários para a geração dos gráficos",
 *      description="{O type pode ser: participation, evaluation, initiativeCreated, initiativeCreatedByType initiativeCreatedByTags, interests, skills",
 *     @SWG\RequestBody(
 *         @SWG\MediaType(
 *             mediaType="application/json",
 *             @SWG\Schema(
 *                 @SWG\Property(
 *                     property="data",
 *                     type="array",
 *                      @SWG\Items(
 *                          @SWG\Property(property="type",type="integer"),
 *                          @SWG\Property(
 *                              property="filters",
 *                              type="array",
 *                              @SWG\Items(
 *                                  @SWG\Property(property="tag",type="text"),
 *                                  @SWG\Property(property="start_time",type="datetime"),
 *                                  @SWG\Property(property="end_time",type="datetime"),
 *                                  @SWG\Property(property="type",type="integer"),
 *                              )
 *                          ),
 *                         )
 *                      ),
 *                 example={ "type":"skills", "filters":{ "tag":"4", "start_time":"2020-03-13 21:55:38", "end_time":"2020-05-11 21:55:38", "type":1 } },
 *                 required={"type"},
 *             )
 *         )
 *     ),
 *      @SWG\Response(
 *          response=200,
 *          description="quando as demais opções",
 *          @SWG\MediaType(
 *              mediaType="application/json",
 *              @SWG\Schema(
 *                 @SWG\Property(
 *                     property="data",
 *                     type="array",
 *                     @SWG\Items(
 *                        @SWG\Property(property="indicator",type="number"),
 *                        @SWG\Property(property="period",type="datetime"),
 *                  )
 *                ),
 *                 example={ "skills",  {{ "tag_id": { "id": 1, "name": "Esportes", "created_at": null, "updated_at": null }, "total": 1 }}},
 *                 example={ "data":  { "indicator": 0, "period": "2020-03-13 21:55:38" }},
 *
 *              )
 *          )
 *       ),
 *       @SWG\Response(response=400, description="Bad request"),
 *       security={
 *           {"api_key_security_example": {}}
 *       }
 *     )
 *
 *
 */
