<?php

namespace App\Http\Controllers;


use App\Task;

class HomeController extends Controller
{

    //home controller for redirect to view

    public function index()
    {
        return View('pages.index');
    }

    public function usersList()
    {
        return View('pages.users_list');
    }

    public function taskDetail($id)
    {
        //check if task is exist then redirect to page with object like a params
        if ($id) {
            $task = Task::find($id);
            if ($task) {
                return View('pages.task_detail', compact('task'));
            }
        }
        return "No task found";
    }


}
