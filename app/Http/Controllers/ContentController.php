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
