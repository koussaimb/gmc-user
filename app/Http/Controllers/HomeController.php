<?php

namespace App\Http\Controllers;


use App\Task;
use Illuminate\View\View;

class HomeController extends Controller
{


    public function index(){
        return View('pages.index');
    }

    public function usersList(){
        return View('pages.users_list');
    }

    public function taskDetail($id){
        if ($id){
            $task = Task::find($id);
            if ($task){
                return View('pages.task_detail', compact('task'));
            }
        }
        return "No task found";
    }


}
