<?php

namespace App\Http\Controllers;

use App\Http\Resources\TaskResource;
use App\Task;
use App\User;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = Task::all();
        return TaskResource::collection($tasks);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //check if user existe before store a task
        $user = User::find($request->user_id);
        if ($user){
                $task = new Task();
                $task->name = $request->name;
                $task->description = $request->description;
                $task->status = $request->status;
                $task->user()->associate($user);
                $task->save();
        }
        return new TaskResource($task);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if ($id){
            $user = User::find($id);
            if ($user){
                return $user;
            }
        }
        return "no user found";
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
        $task = Task::find($id);
        $task->name = $request->name;
        $task->description = $request->description;
        $task->status = $request->status;
        $task->save();
        return new TaskResource($task);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $task = Task::findOrfail($id);
        if($task->delete()){
            return  new TaskResource($task);
        }
        return "Error while deleting";
    }

    public function tasksByUser($user_id){

        $user = User::find($user_id);
        if ($user){
            $task = Task::where('user_id', $user_id)->get();

            return  new TaskResource($task);
        }

        return "No Task Found";
    }
}
