<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

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
        $users =User::get();

        foreach ($users as $key) {
            $user =User::where('id',$key->id)->first();
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
               
            }
        }

        return "success";
    }

    public function index()
    {
        return view('home');
    }
}
