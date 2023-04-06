<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment\Payment;
use App\Models\Payment\PaymentLog;
use App\Models\Member\Member;
use App\Models\Member\MemberStock;
use App\Models\User;
use App\Http\Resources\PaymentLogResource;
use App\Services\SavingService;
use Hash;
use Validator;

class PaymentController extends Controller
{
    public function paymentRequest(Request $request){
        $validator = Validator::make(
            $request->all(), [
                'member_id' =>'required',
                'type'      =>'required',
                'amount'    =>'required',
                'phone_number' =>'required',
                'network_type' =>'required'
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

        $valid_data =$validator->valid();

        $member =Member::where('member_reg_id',$valid_data['member_id'])->first();

        if (!$member) {
            return response()->json([
                'success' =>false,
                'error-message' =>'Mwanachama Hajasajiliwa Bado',
            ],500);
        }

        $payment_log =[
            'member_id'        =>$member->id,
            'member_reg_id'    =>$member->member_reg_id,
            'amount'           =>$valid_data['amount'],
            'msisdn'           =>$valid_data['phone_number'],
            'status'           =>"Request",
            'type'             =>$valid_data['type'],
            'network_type'     =>$valid_data['network_type'],
            'callback_url'     =>asset('/api/payment-callback'),
        ];

        $payment =PaymentLog::store($payment_log);

        return response()->json([
            'success' =>true,
            'message' =>'Ombi Lako Limefanikiwa',
            'data'   =>new PaymentLogResource($payment)
        ],200);

    }

    public function c2b_payment(Request $request){
        $insight_reference     =$request->input('insight_reference');
        $payment_reference     =$request->input('payment_reference');
        $payment_status        =$request->input('payment_status');
        $amount                =$request->input('amount');
        $msisdn                =$request->input('msisdn');

        // $payment =Payment::where('payment_reference',$payment_reference)->first();
        // if($payment){
        //     return response()->json([
        //         'success' =>false,
        //         'message' =>"Payment Reference has already used",
                
        //     ],200);
        // }

        //this condition when member pay and put correct insight reference

        $payment_log =PaymentLog::where('order_reference',$insight_reference)->first();

        if ($payment_log) {

            $payment_type =$payment_log->type;
            $payment_load =[
                'msisdn'    =>$msisdn,
                'amount'    =>$amount,
                'payment_reference' =>$payment_reference,
                'insight_reference' =>$insight_reference,
                'status'            =>'success',
                'type'              =>$payment_log->type,
                'member_id'         =>$payment_log->member_id,
                'member_reg_id'     =>$payment_log->member_reg_id,
            ];

            if ($payment_type == "Registration Fee") {
                $payment =Payment::store($payment_load);

                $member =Member::where('id',$payment->member_id)->first();

                if ($member) {
                    $reg_fee_paid        =$member->registration_fee;
                    $registration_status =$member->registration_status;
                    $total_reg_fee        =$reg_fee_paid + $payment->amount;

                    if ($total_reg_fee >= 10000) {
                        $registration_status ="Member";

                        //activate credentials

                        $user =User::where('username',$member->member_reg_id)->first();
                        $user->status ="Active";
                        $user->password =Hash::make('ACT@2023');
                        $user->save();
                    }

                    $member->registration_fee    =$total_reg_fee;
                    $member->registration_status =$registration_status;
                    $member->save();

                    return response()->json([
                        'success' =>true,
                        'message' =>'Mwanachama amefanikiwa Kulipa Ada ya Kujiunga na SHUSHATANGA SACCOS',
                    ],200);

                }

            }elseif ($payment_type == "Member Stock") {
                $payment =Payment::store($payment_load);

                $member_stock =MemberStock::store($payment);

                return response()->json([
                    'success' =>true,
                    'message' =>'Mwanachama amefanikiwa Kununua Hisa Kwenye SHUSHATANGA SACCOS',
                ],200);
                
            }else {
                $payment =Payment::store($payment_load);

                $saving  =SavingService::saving($payment);

                return $saving;

            }

        }

        // end condition when member pay and put correct insight reference

        return $request->all();
        
    }

  
}
