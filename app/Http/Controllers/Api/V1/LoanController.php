<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Member\Member;
use App\Models\Member\MemberSavingSummary;
use App\Http\Resources\MemberResource;
use App\Http\Resources\LoanAttendResource;
use App\Http\Resources\LoanApplicationResource;
use App\Http\Resources\LoanResource;
use App\Models\Loan\LoanApplication;
use App\Models\Loan\LoanGuarantor;
use App\Models\User;
use Hash;
use Spatie\Permission\Models\Role;
use Carbon\Carbon;


class LoanController extends Controller
{  
    public function memberLoans(Request $request){
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

        $member =Member::where('member_reg_id',$member_id)->first();

        if (!$member) {
            return response()->json([
                'success' =>false,
                'error-message' =>"Mwanachama Hajasajiliwa"
            ],500);
        }
        return response()->json([
            'success' =>true,
            'data'    =>LoanResource::collection($member->loan_contracts),
        ],200);


    }

    public function getGuarantor(Request $request){
        $validator = Validator::make(
            $request->all(), [
                'member_id' =>'required',
                'amount'    =>'required',
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
        $amount    =$request->input('amount');

        $member =Member::with('member_saving')->where('member_reg_id',$member_id)->first();

        if ($member) {
            if ($member->member_saving) {
                $current_saving =$member->member_saving->current_saving;
                if ($current_saving < ($amount/2)) {
                    return response()->json([
                        'success' =>false,
                        'error-message' =>"Mwanachama hana uwezo wa kumdhamini mwanachama mwingine"
                    ],500);
                }
            }else {
                return response()->json([
                    'success' =>false,
                    'error-message' =>"Mwanachama hana uwezo wa kumdhamini mwanachama mwingine"
                ],500);
            }
            return response()->json([
                'success' =>true,
                'message' =>"Mwanachama Yupo",
                'data'    =>new MemberResource($member)
            ],200);
        } else {
            return response()->json([
                'success' =>false,
                'error-message' =>"Mwanachama Hajasajiliwa"
            ],500);
        }
        
    }

    public function loanApplication(Request $request){
        $validator = Validator::make(
            $request->all(), [
                'member_id' =>'required',
                'plan'      =>'required',
                'amount'    =>'required',
                'guarantor_member_id' =>'required',
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

        $member_data =$validator->valid();
        $guarantor_member_id =$request->input('guarantor_member_id');

        $member =Member::where('member_reg_id',$member_data['member_id'])->first();

        if (!$member) {
            return response()->json([
                'success' =>false,
                'error-message' =>"Mwanachama hajasajiliwa"
            ],500);
        }


        if (!$member->member_saving) {
            return response()->json([
                'success' =>false,
                'error-message' =>"Mwanachama hana akiba yeyote aliyojiwekea"
            ],500);
        }

        if ($member->created_at->gt(Carbon::now()->subMonths(3))) {
            return response()->json([
                'success' =>false,
                'error-message' =>"Mwanachama hajafikisha mda wakuweza kukopa"
            ],500);
        }

        $loan_limit =3*$member->member_saving->current_saving;
        if ($member_data['amount'] > $loan_limit) {
            return response()->json([
                'success' =>false,
                'error-message' =>"Kiasi cha mkopo ni kikubwa kuliko kiwango cha akiba zake"
            ],500);
        }

        if ($member_data['amount'] > $member->member_saving->current_saving) {
            if (sizeof($guarantor_member_id) != 2) {
                return response()->json([
                    'success' =>false,
                    'error-message' =>"Wadhamini Hawatoshi"
                ],500);
            }
        }

        if ($member->has_loan_application()) {
           $loan =$member->loan_application;
           $loan->level ="CLOSED";
           $loan->save();
        }

        if ($member->has_loan_contract()) {
            return response()->json([
                'success'       =>false,
                'error-message' =>"Mwanachama ana mkopo ambao hajaulipa bado",
                'data'    =>new LoanResource($member->loan_contract)
            ],200);
        }

        $loan =LoanApplication::store($member_data,$member->id);

        if ($member_data['amount'] > $member->member_saving->current_saving) {
            $guarantors =LoanGuarantor::store($member_data['guarantor_member_id'],$loan->id);
        }

        return response()->json([
            'success' =>true,
            'message' =>"Mwanachama Amefanikiwa Kuomba Mkopo",
            'data'    =>new LoanApplicationResource($loan)
        ],200);
    }

    public function loanApprove(Request $request){
        $validator = Validator::make(
            $request->all(), [
                'guarantor_uuid' =>'required',
                'status'         =>'required',
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

        $request_data =$validator->valid();

        $loan_guarantor =LoanGuarantor::where('uuid',$request_data['guarantor_uuid'])->first();
        $loan_guarantor->status  =$request_data['status'];
        $loan_guarantor->remarks =$request_data['remarks'];
        $loan_guarantor->save();

        return response()->json([
            'success' =>true,
            'message' =>"Ombi Limefanyika Kikamilifu",
        ],200);
 
    }

    public function loansToAttend(Request $request){
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
        $guarantor =LoanGuarantor::with('loan_application','loan_application.member')
                    ->whereHas('loan_application')
                    ->where('member_reg_id',$member_id)->get();

        if (!$guarantor) {
            return response()->json([
                'success' =>false,
                'error-message' =>'Mwanachama Hana Mikopo Ya Kupitsha',
            ],500);
        }

        return response()->json([
            'success' =>true,
            'data'    =>LoanAttendResource::collection($guarantor),
        ],200);
    }
}
