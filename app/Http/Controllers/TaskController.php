<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Session;

class TaskController extends Controller
{
   

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //

        $userId =Session::get(user);;
        dd($userId);

        $tasks = Task::all();
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
       
       

        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:tasks',
            'description' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

      
        
        $task = new Task($request->all());
        $task->save();

      
         // Attach categories if provided
    if (isset($request->categories)) {
        $a=explode("," ,$request->categories);;
        foreach($a as $x){
            $task->categories()->attach($x);
        }

    }
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

        $task = Task::find($id);
            if (empty($task)) {
    return response()->json(['message' => 'Task not found'], 404);
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

        $task = Task::find($id);

        if ($task->user_id !== auth()->id()) {

            return response()->json(['error' => 'Unauthorized'], 403);
    }
    else{
        
        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:tasks,id,' . $id, // exclude current id
            'description' => 'required'
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
    public function destroy($id)
    {
        //
        $task = Task::find($id);

        if ($task->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
    
     else{
      if (!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }
        $task->delete();
        return response()->json(['message' => 'Task deleted successfully']);

    }

    }

    public function complete($id)
    {
        //
        $task = Task::find($id);

        if ($task->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
    
     else{
      if (!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }
        $task->update(['complete'=>'1']);
        return response()->json(['message' => 'Task completed successfully']);

    }

    }


}
