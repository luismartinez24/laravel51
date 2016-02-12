<?php

namespace laravel51\Http\Controllers;
use Validator;
use DB;
use Crypt;
use laravel51\User;
use Session;
use Redirect;
use Illuminate\Http\Request;
use laravel51\Http\Requests\UserCreateRequest;
use laravel51\Http\Requests\UserUpdateRequest;

use laravel51\Http\Requests;
use laravel51\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /*$users = User::all();*/

        $users = DB::table('users')->select('id','name', 'email', 'password')->get();
        return view('user.index')->with('users',$users);
      
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

       $validator = Validator::make($request->all(), [
            'name' => 'required|unique:users|max:20',
            'email' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {

            return redirect('user/create')->withErrors($validator)->withInput();
        }
        else
        {

         /*User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => $request['password'],
         ]);*/

        DB::table('users')->insert(
         ['name' => $request->input('name'), 
          'email' => $request->input('email'), 
          'password' => Crypt::encrypt($request->input('password')) ]
        );

        return redirect('user')->with('message', 'store');

        }

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
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        return view('user.edit')->with('user',$user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, $id)
    {
        $user = User::find($id);
        $user->fill($request->all());
        $user->save();
        Session::flash('message','update');
        return Redirect::to('/user');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::destroy($id);      
        return Redirect::to('/user')->with('message','delete');       
    }
}
