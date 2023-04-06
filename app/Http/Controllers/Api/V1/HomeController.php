<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Member\Member;
use App\Http\Resources\HomepageResource;
use Validator;

class HomeController extends Controller
{
    public function index(Request $request){
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

        $member =Member::with('loan_contracts','member_saving','member_stocks')->where('member_reg_id',$member_id)->first();

        if (!$member) {
            return response()->json([
                'success' =>false,
                'error-message' =>'Mwanachama Hajasajiliwa Bado',
            ],500);
        }

        return response()->json([
            'success' =>true,
            'data'    =>new HomepageResource($member),
        ],200);
    }

   

}
