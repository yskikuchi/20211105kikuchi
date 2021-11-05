<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items=Post::with('user:id,name,firebase_uid')
        ->orderBy('id','desc')
        ->get();
        return response()->json([
            'data'=>$items
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate_rule = [
            'user_id' => 'required',
            'content' => 'required|max:120'
        ];
        $this->validate($request, $validate_rule);

        $item = Post::create($request->all());
        return response()->json([
            'data' => $item
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        $item = Post::with('favorites')->get();
        if ($item) {
        return response()->json([
            'data' => $item
        ], 200);
        } else {
        return response()->json([
            'message' => 'Not found',
        ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $item = Post::where('id', $post->id)->delete();
        if ($item) {
            return response()->json([
            'message' => 'Deleted successfully',
        ], 200);
        } else {
            return response()->json([
            'message' => 'Not found',
        ], 404);
    }}
}