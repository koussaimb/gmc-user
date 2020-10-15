<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return UserResource::collection($users);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50',
            'first_name' => 'required|string|max:50',
            'email' => 'required|email|unique:users',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);

        }


        $user = new User();
        $user->name = $request->name;
        $user->first_name = $request->first_name;
        $user->email = $request->email;
        $user->save();
        return new UserResource($user);
    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if ($id) {
            $user = User::find($id);
            if ($user) {
                return $user;
            }
        }
        return "no user found";
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50',
            'first_name' => 'required|string|max:50',
            'email' => 'required|email|unique:users',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);

        }

        $user = User::find($id);
        $user->name = $request->name;
        $user->first_name = $request->first_name;
        $user->email = $request->email;
        $user->save();

        return new UserResource($user);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrfail($id);
        if ($user->delete()) {
            return new UserResource($user);
        }

        return "Error while deleting";
    }
}
