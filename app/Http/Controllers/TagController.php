<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tag;

class TagController extends Controller
{
    public function index(?int $id): ?object
    {
        $tag = Tag::where('task_id',$id)->first();
        return $tag;
    }

    /**
     * api/tags
     * POST
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): object
    {
        $tag = Tag::create($request->all());
        return $tag
        ? response()->json($tag,201)
        : response()->json(['Error'],500);
    }

    /**
     * api/tags/{id}
     * PATCH
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tag $tag
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Tag $tag): object
    {
        $tag->checked_red = $request->checked_red;
        $tag->checked_blue = $request->checked_blue;
        $tag->checked_yellow = $request->checked_yellow;
        $tag->checked_green = $request->checked_green;
        return $tag->update() 
        ? response()->json($tag)
        : response()->json(['Error'],500);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
