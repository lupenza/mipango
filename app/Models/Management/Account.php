<?php

namespace App\Models\Management;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    public function account_type(){
        return $this->hasOne(AccountType::class,'id','account_type_id');
    }

    public function scopeWithFilters($query,$request){
        $account_id    =$request['account'] ?? null;

        return $query->when($account_id,function($query) use ($account_id){
            $query->where('account_type_id',$account_id);
        });
       
    }
}
