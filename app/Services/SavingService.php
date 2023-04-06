<?php

namespace App\Services;
use App\Models\Member\MemberSaving;
use DateTime;


class SavingService 
{
    public static function saving($payment){
        $member_id    =$payment['member_id'];
        $member_reg_id =$payment['member_reg_id'];
        $amount        =$payment['amount'];
        $payment_id    =$payment['id'];
        $payment_date  =$payment['created_at'];


        $member_saving =MemberSaving::where('member_id',$member_id)->latest()->first();


        if (!$member_saving) {
            ## case 1 when saving is empty that means new member so create 
            if ($amount >= 5000) {
              $remark ="Completed";
            } else {
                $remark ="Not Completed";
            }

            $saving_pay_load =[
                'member_id'     =>$member_id,
                'member_reg_id' =>$member_reg_id,
                'payment_id'    =>$payment_id,
                'amount'        =>$amount,
                'from_date'     =>date('Y-m-d',strtotime($payment_date)),
                'to_date'       =>date('Y-m-d', strtotime("+1 months", strtotime($payment_date))),
                'remark'        =>$remark,
            ];

            $member_store_stock =MemberSaving::store($saving_pay_load);

            return  response()->json([
                'success' =>true,
                'message' =>"Kiasi cha Akiba Kimepokelewa",
            ],200);
            

        } else {
            ## case 2 the member already exist in  saving
            ## case 2(1) didnt complete last saving.

            $member_remark =$member_saving->remark;
            $last_end_date =$member_saving->to_date;
            $to_day        =date('Y-m-d');

            $to_day        =new DateTime($to_day);
            $last_end_date =new DateTime($last_end_date);

            if ($member_remark == "Not Completed") {

                if ($to_day < $last_end_date) {
                    ## case 2(1)(a) didnt complete last saving but the time was not over due

                    $total_amount_saved =$amount + $member_saving->amount;

                    if ($total_amount_saved >= 5000) {
                        $remark ="Completed";
                        
                    } else {
                        $remark ="Not Completed";
                    }
                    
                    $saving_pay_load =[
                        'member_id'     =>$member_id,
                        'member_reg_id' =>$member_reg_id,
                        'payment_id'    =>$payment_id,
                        'amount'        =>$amount,
                        'from_date'     =>$member_saving->from_date,
                        'to_date'       =>$member_saving->to_date,
                        'remark'        =>$remark,
                    ];
        
                    $member_store_stock =MemberSaving::store($saving_pay_load);

                    ## Update the previous remark
                    $member_saving->remark =$member_store_stock->remark;
                    $member_saving->save();
                    
                    // return  response()->json([
                    //     'success' =>true,
                    //     'message' =>"Kiasi cha Akiba Kimepokelewa",
                    // ],200);

                } else {
                     ## case 2(1)(a) didnt complete last saving but the time is over due

                     while($amount > 0) {
                        if ($amount < 5000) {
                            $member_uncompleted_savings =MemberSaving::where(['member_id'=>$member_id,'remark'=>'Not Completed'])->latest()->get();
                            $actual_amount =$member_uncompleted_savings->sum('amount') + $amount;
                            if ($actual_amount < 5000) {
                                $saving_pay_load =[
                                    'member_id'     =>$member_id,
                                    'member_reg_id' =>$member_reg_id,
                                    'payment_id'    =>$payment_id,
                                    'amount'        =>$amount,
                                    'from_date'     =>$member_saving->from_date,
                                    'to_date'       =>$member_saving->to_date,
                                    'remark'        =>"Not Completed",
                                ];
                    
                                $member_store_stock =MemberSaving::store($saving_pay_load);
                                break;
            
                            } else {
                                $member_uncompleted_savings =MemberSaving::where(['member_id'=>$member_id,'remark'=>'Not Completed'])->latest()->get();
                                $amount_close_last_saving =5000 -$member_uncompleted_savings->sum('amount');

                                $amount_diff =$amount - $amount_close_last_saving;
                               // return $amount_close_last_saving;

                                if ($amount_diff > 0) {
                                    $saving_pay_load =[
                                        'member_id'     =>$member_id,
                                        'member_reg_id' =>$member_reg_id,
                                        'payment_id'    =>$payment_id,
                                        'amount'        =>$amount_close_last_saving,
                                        'from_date'     =>$member_saving->from_date,
                                        'to_date'       =>$member_saving->to_date,
                                        'remark'        =>"Completed",
                                    ];
                        
                                    $member_store_stock =MemberSaving::store($saving_pay_load);
                
                                    ## Update the previous remark
                                    foreach ($member_uncompleted_savings as $saving) {
                                        $saving->update(['remark' => 'Completed']);
                                    }

                                    ##remain balance
                                    $remain_amount =$amount_diff;
                                } else {
                                    
                                    $saving_pay_load =[
                                        'member_id'     =>$member_id,
                                        'member_reg_id' =>$member_reg_id,
                                        'payment_id'    =>$payment_id,
                                        'amount'        =>$amount,
                                        'from_date'     =>$member_saving->from_date,
                                        'to_date'       =>$member_saving->to_date,
                                        'remark'        =>"Not Completed",
                                    ];

                                    $member_store_stock =MemberSaving::store($saving_pay_load);

                                    break;
                                }
                            }
                            
                        } else {
                            $amount_close_last_saving =5000 -$member_saving->amount;

                            $saving_pay_load =[
                                'member_id'     =>$member_id,
                                'member_reg_id' =>$member_reg_id,
                                'payment_id'    =>$payment_id,
                                'amount'        =>$amount_close_last_saving,
                                'from_date'     =>$member_saving->from_date,
                                'to_date'       =>$member_saving->to_date,
                                'remark'        =>"Completed",
                            ];
                
                            $member_store_stock =MemberSaving::store($saving_pay_load);
        
                            ## Update the previous remark
                            $member_saving->remark =$member_store_stock->remark;
                            $member_saving->save();

                            ##remain balance
                            $remain_amount =$amount - $member_store_stock->amount;

                        }

                        $amount =$remain_amount;
                        
                     }

                }

            } else {
                if ($to_day < $last_end_date) {
                      ## case 2(2)(a) complete last saving but the time was still within that month
                      
                      $saving_pay_load =[
                          'member_id'     =>$member_id,
                          'member_reg_id' =>$member_reg_id,
                          'payment_id'    =>$payment_id,
                          'amount'        =>$amount,
                          'from_date'     =>$member_saving->from_date,
                          'to_date'       =>$member_saving->to_date,
                          'remark'        =>"Completed",
                      ];
          
                      $member_store_stock =MemberSaving::store($saving_pay_load);

                    //   return  response()->json([
                    //     'success' =>true,
                    //     'message' =>"Kiasi cha Akiba Kimepokelewa",
                    // ],200);

                } else {
                    if ($amount < 5000) {
              
                          $saving_pay_load =[
                              'member_id'     =>$member_id,
                              'member_reg_id' =>$member_reg_id,
                              'payment_id'    =>$payment_id,
                              'amount'        =>$amount,
                              'from_date'     =>date('Y-m-d',strtotime($member_saving->to_date)),
                              'to_date'       =>date('Y-m-d', strtotime("+1 months", strtotime($member_saving->to_date))),
                              'remark'        =>"Not Completed",
                          ];
              
                          $member_store_stock =MemberSaving::store($saving_pay_load);
              
                        //   return  response()->json([
                        //       'success' =>true,
                        //       'message' =>"Kiasi cha Akiba Kimepokelewa",
                        //   ],200);
                    } else {

                        while ($amount > 0) {
                            $last_end_date =$member_saving->to_date;
                            $to_day        =date('Y-m-d');
                
                            $to_day        =new DateTime($to_day);
                            $last_end_date =new DateTime($last_end_date);
                            $interval = $to_day->diff($last_end_date);
                            $days = $interval->days;

                            if ($days <= 30) {
                                $saving_pay_load =[
                                    'member_id'     =>$member_id,
                                    'member_reg_id' =>$member_reg_id,
                                    'payment_id'    =>$payment_id,
                                    'amount'        =>$amount,
                                    'from_date'     =>date('Y-m-d',strtotime($member_saving->to_date)),
                                    'to_date'       =>date('Y-m-d', strtotime("+1 months", strtotime($member_saving->to_date))),
                                    'remark'        =>"Completed",
                                ];
                    
                                $member_store_stock =MemberSaving::store($saving_pay_load);
                                break;
                            } else {
                                
                                $member_saving_ =MemberSaving::where('member_id',$member_id)->latest()->first();
                                $saving_pay_load =[
                                    'member_id'     =>$member_id,
                                    'member_reg_id' =>$member_reg_id,
                                    'payment_id'    =>$payment_id,
                                    'amount'        =>5000,
                                    'from_date'     =>date('Y-m-d',strtotime($member_saving_->to_date)),
                                    'to_date'       =>date('Y-m-d', strtotime("+1 months", strtotime($member_saving_->to_date))),
                                    'remark'        =>"Completed",
                                ];
                    
                                $member_store_stock =MemberSaving::store($saving_pay_load);

                                $remain_amount =$amount - 5000;
                            }

                            $amount =$remain_amount;
                            
                        }
                    }
                    
                }
                
            }
            

        }

        return  response()->json([
            'success' =>true,
            'message' =>"Kiasi cha Akiba Kimepokelewa",
        ],200);
        
    }
}

