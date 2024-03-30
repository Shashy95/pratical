<?php

namespace App\Http\Controllers;

use App\Models\PlaceCategory;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class PlaceCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $places = PlaceCategory::all(); // Paginate with 10 items per page
        return response()->json($places);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //

        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:place_categories',

        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $task = new PlaceCategory($request->all());
        $task->save();

        return response()->json($task, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //

        $task = PlaceCategory::find($id);
        if (empty($task)) {
        return response()->json(['message' => 'Place Category not found'], 404);
        }
        else{
        return response()->json($task, 201);
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //

    
        $task =PlaceCategory::find($id);

        
        if (!$task) {
            return response()->json(['message' => 'Place Category not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:place_categories',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $task->update($request->all());
        return response()->json($task);
    


       


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

        $task =PlaceCategory::find($id);

        
        if (!$task) {
            return response()->json(['message' => 'Place Category not found'], 404);
        }

        $task->delete();
        return response()->json(['message' => 'Place Category deleted successfully']);
    }
}
