<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    
    public function index()
    {

    }


    public function create()
    {
        return view('admins.register');
    }




    public function store(Request $request)
    {

        $request->validate([
            'name' => 'string|required|min:5',
            'email' => 'string|required|unique:admins',
            'password'=> 'required|min:8|string|confirmed'
        ]);
        $admin = new Admin();

        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->password = Hash::make($request->password);

        $admin->save();

        return to_route('admin.loginPage');
    }




    public function loginPage() {
        return view('admins.login');

    }

    public function login(Request $request){

        $request->validate([
            'email' => 'string|required',
            'password'=> 'required|string'
        ]);
        if(Auth::guard('admin')->attempt([
            'email' => $request->email,
            'password' => $request->password
        ])) {
            return to_route('admin.dashboard');
        }else {
            return redirect()->back();
        }


    }

    public function dashboard() {
        return view('admins.dashboard');
    }

    public function logout() {
        Auth::guard('admin')->logout();
        return to_route('admin.login');
    }

    public function show(Admin $admin)
    {

    }

    public function edit(Admin $admin)
    {

    }


    public function update(Request $request, Admin $admin)
    {

    }


    public function destroy(Admin $admin)
    {

    }
}
