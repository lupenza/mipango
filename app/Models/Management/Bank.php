<?php

namespace App\Models\Management;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    use HasFactory;

    protected $fillable=['name','common_name','account_type_id','logo','created_at','uuid','updated_by'];
   // public $primaryKey ='uuid';
   protected $primaryKey = 'uuid';
   public $incrementing = false;

    public function account_type(){
        return $this->hasOne(AccountType::class,'id','account_type_id');
    }
}
