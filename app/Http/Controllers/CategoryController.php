<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Session;

class CategoryController extends Controller
{
   

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $tasks = Category::all();
        return response()->json($tasks);
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

        $userId =$request->session()->get('user_id'); // Retrieve user ID from session

        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:categories',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

      
        
        $task = new Category($request->all());
        $task->user_id=$userId;
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

        $task = Category::find($id);
            if (empty($task)) {
    return response()->json(['message' => 'Category not found'], 404);
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

        $task = Category::find($id);

        $userId =$request->session()->get('user_id'); // Retrieve user ID from session

        if ($task->user_id !== $userId) {

            return response()->json(['error' => 'Unauthorized'], 403);
    }
    else{
        
        if (!$task) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:categories,id,' . $id, // exclude current id
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $task->update($request->all());
        return response()->json($task);
    }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,Request $request)
    {
        //
        $task = Category::find($id);
        $userId =$request->session()->get('user_id'); // Retrieve user ID from session

        if ($task->user_id !== $userId) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
    
     else{
      if (!$task) {
            return response()->json(['message' => 'Category not found'], 404);
        }
        $task->delete();
        return response()->json(['message' => 'Category deleted successfully']);

    }

    }

   

}
