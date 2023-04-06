<?php

namespace App\Models\Management;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountType extends Model
{
    use HasFactory;

    protected $table='account_type';

    protected $fillable =['name','uuid','created_by','updated_by','description','name_sw'];
}
