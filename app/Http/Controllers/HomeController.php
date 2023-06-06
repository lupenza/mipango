<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    
    public function user(){
        set_time_limit(0);

        $table =
        
        $done = 0;
        $users =User::query()->latest()->chunk(100, function($users) use($done) {
            foreach ($users as $user) {
                if ($user) {
                    switch ($user->role_id) {
                     case 1:
                         $role ="Super Admin";
                         break;
                     
                     case 3:
                         $role ="User";
                         break;
                     
                     default:
                         $role="Admin";
                         break;
                    }
     
                    $user->assignRole($role);
                    $done ++;
                 }
               
            }
        });

       

        return "success " . $done;
    }

    public function index()
    {
        return view('home');
    }
}
