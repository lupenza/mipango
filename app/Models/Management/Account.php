<?php

namespace App\Models\Management;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    public function account_type(){
        return $this->hasOne(Accounttype::class,'id','account_type_id');
    }
}