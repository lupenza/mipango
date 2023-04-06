<?php

namespace App\Models\Management; 

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable =['name','name_en','uuid','created_by','updated_by','icon','icon_url','status','category_group'];
}
