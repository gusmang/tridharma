<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::where('id','<>',1)->get();

        return view('dashboard.user.index',['users'=>$users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.user.form',['user'=>[]]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'      =>'required|String|Unique:users,name',
            'first_name'=>'required|String',
            'last_name' =>'required|String',
            'email'     =>'required|Email|String|Unique:users,email',
            'password' =>'required|confirmed',
            'role'      =>'required|in:admin,staff',
        ]);
        // dd($request->all());
        $user = new User;
        $user->name         = strip_tags($request->name);
        $user->first_name   = strip_tags($request->first_name);
        $user->last_name    = strip_tags($request->last_name);
        $user->email        = strip_tags($request->email);
        $user->role         = strip_tags($request->role);
        $user->password     = Hash::make($request->password);
        $user->is_active    = true;
        $user->save();

        return redirect()->route('user.index')->with('notif-success','User baru telah di buat');

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
        return view('dashboard.user.form',['user'=>User::findOrFail($id)]);
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
        $request->validate([
            'name'      =>'required|String',
            'first_name'=>'required|String',
            'last_name' =>'required|String',
            'email'     =>'required|Email|String',
            'role'      =>'required|in:admin,staff',
        ]);
        // dd($request->all());
        // check name
        $check_name = User::where('name',$request->name)->where('id','<>',$id)->count();
        if($check_name)
            return back()->with('notif-warning','Username sudah di ambil');

        $check_email = User::where('email',$request->email)->where('id','<>',$id)->count();
        if($check_email)
            return back()->with('notif-warning','Email sudah di ambil');


        $user = User::findOrFail($id);
        $user->name         = strip_tags($request->name);
        $user->first_name   = strip_tags($request->first_name);
        $user->last_name    = strip_tags($request->last_name);
        $user->email        = strip_tags($request->email);
        $user->role         = strip_tags($request->role);
        $user->is_active    = true;
        $user->save();

        return redirect()->route('user.index')->with('notif-success','User baru telah di buat');
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
    }
}
