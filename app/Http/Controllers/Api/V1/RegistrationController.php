<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Http;
use App\Models\Member\Member;
use App\Http\Resources\MemberResource;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Hash;


class RegistrationController extends Controller
{
    public  $base_url;
    public function __construct(){
        $this->base_url ="https://act-kiganjani.co.tz/api";
    }
    public function memberRegistration(Request $request){
        $validator = Validator::make(
            $request->all(), [
                'member_id' =>'required',
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
        $member_id =$request->input('member_id');
        $check_member =Member::where('member_reg_id',$member_id)->first();

        if ($check_member) {
            return response()->json([
                'success' =>true,
                'message' =>'Mwanachama Amesajiliwa',
                'data'   =>new MemberResource($check_member)
            ],200);
        }
       
        $url =$this->base_url.'/'."member/".$member_id;
        $member =Http::get($url);

        if ($member['success']) {
            $create_member =Member::store($member['data']);
            return response()->json([
                'success' =>true,
                'message' =>'Mwanachama Amesajiliwa',
                'data'   =>new MemberResource($create_member)
            ],200);
        } else {
            return response()->json([
                'success' =>false,
                'error-message' =>$member['error-message']
            ],500);
        }

    }

    public function setPassword(Request $request){
        $validator = Validator::make(
            $request->all(), [
                'member_id' =>'required',
                'password'  =>['required','min:6','max:20']
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

        $member_id =$request->input('member_id');
        $password  =$request->input('password');

        $check_member =Member::where('member_reg_id',$member_id)->first();

        if (!$check_member) {
            return response()->json([
                'success' =>false,
                'error-message' =>'Mwanachama Hajasajiliwa Bado',
            ],500);
        }

        $user =User::where('username',$member_id)->first();

        if (!$user) {
            return response()->json([
                'success' =>false,
                'error-message' =>'Mwanachama Hajasajiliwa Bado',
            ],500);
        }

        $user->password =Hash::make($password);
        $user->save();

        return response()->json([
            'success' =>true,
            'message' =>'Mwanachama Amefanikiwa Kuset Password',
            'data'   =>new MemberResource($check_member)
        ],200);

    }
}
