<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use App\Http\Resources\MemberResource;
use Validator;

class LoginController extends Controller
{
    public function userLogin(Request $request){
        $validator = Validator::make(
            $request->all(), [
                'username' =>'required',
                'password' =>'required',
            ]
        );

        if ($validator->fails() ) {
            return response()->json(
                [
                    'success' => false,
                    'error-message' => $validator->errors(),
                ], 500
            );
        }

        $user_request =$validator->valid();

        if (Auth::attempt(['username' => $user_request['username'], 'password' => $user_request['password']])) {
            $user = User::find(auth()->user()->id);
            if ($user->status == "Active") { 
               if ($user->hasRole('Member')) {
                return response()->json([
                    'success'  =>true,
                    'message'  =>$user->name.' Karibu Tena Kwenye  ShushaTanga Saccos',
                    'data'     =>new MemberResource($user->member),
                    'token'    =>$user->createToken($user->username)->plainTextToken,
                ],200);
               } else {
                Auth::logout();
                return response()->json([
                    'success' =>false,
                    'error-message' =>"Hauna Ruhusa Ya Kupata Huduma Hii",
                ],500);
               }
               

            } else {
                Auth::logout();
                return response()->json([
                    'success' =>false,
                    'error-message' =>"Account Yako Haipo Active , Wasiliana na Uongozi Wa ShushaTanga SACCOS",
                ],500);
            }
        } else {
            return response()->json([
                'success' =>false,
                'error-message' =>'Namba ya Uanachama au Password Sio Sahihi',
            ],500);
        }
    }
}
