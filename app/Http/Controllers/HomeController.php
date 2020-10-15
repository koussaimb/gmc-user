<?php

namespace App\Http\Controllers;


use Illuminate\View\View;

class HomeController extends Controller
{


    public function index(){
        return View('pages.index');
    }

    public function usersList(){
        return View('pages.users_list');
    }


}
