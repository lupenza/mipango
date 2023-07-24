<?php

namespace App\Models\Management;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;


class Ledger extends Model
{
    use HasFactory;

    public function user(){
        return $this->hasOne(User::class,'id','user_id');
    }

    public function category(){
        return $this->hasOne(Category::class,'id','category_id');
    }

    public function account(){
        return $this->hasOne(Account::class,'id','account_id');
    }

    public function scopeWithFilters($query,$request){
        $start_date    =$request['start_date'] ?? null;
        $end_date      =$request['end_date'] ?? null;
        $category      =$request['category'] ?? null;
        $tranx_type    =$request['transaction_type'] ?? null;
        $amount        =$request['amount'] ?? null;


        return $query->when($category,function($query) use ($category){
            $query->where('category_id',$category);
        })
        ->when($tranx_type,function($query) use ($tranx_type){
            $query->where('txn_type',$tranx_type);
        })
        ->when($amount,function($query) use ($amount){
            if ($amount =="10000000+") {
                $query->where('amount','>',10000000);
            }else{
                list($amountfrom, $amountto) = explode("-", $amount);
                $query->whereBetween('amount',[$amountfrom,$amountto]);
            }
        })
        ->when($start_date,function($query) use ($start_date,$end_date){
            if ($start_date != null || $end_date != null) {
                if ($start_date != null && $end_date != null)
                    $query->whereBetween('created_at', [$start_date, $end_date]);
    
                else if ($start_date != null)
                    $query->where('created_at', '>=', $start_date);
    
                else if ($end_date != null)
                    $query->where('created_at', '<=', $end_date);
            }
        });
       
    }

    
}
