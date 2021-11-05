<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FavoriteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $item= Favorite::all();
        $count=Favorite::groupBy('post_id')
        ->select('post_id', DB::raw("count(user_id) as fav"))
        ->get();
        return response()->json([
            'data' => $item,
            'count' => $count
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
            'post_id' => 'required'
        ];
        $item=Favorite::create($request->all());
        return response()->json([
            'data'=>$item
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Favorite  $favorite
     * @return \Illuminate\Http\Response
     */
    public function show(Favorite $favorite)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Favorite  $favorite
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Favorite $favorite)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Favorite  $favorite
     * @return \Illuminate\Http\Response
     */
    public function destroy(Favorite $favorite)
    {
        $item = Favorite::where('id', $favorite->id)->delete();
        if ($item) {
            return response()->json([
            'message' => 'Deleted successfully',
        ], 200);
        } else {
            return response()->json([
            'message' => 'Not found',
        ], 404);
        }
    }
}