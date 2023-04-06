<?php

namespace App\Models\Management;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Budget extends Model
{
    use HasFactory;

    public $table='budget';

    public function user(){
        return $this->hasOne(User::class,'id','user_id');
    }

    public function category(){
        return $this->hasOne(Category::class,'id','budget_category_id');
    }

    public function scopeWithFilters($query,$request){
        $start_date    =$request['start_date'] ?? null;
        $end_date      =$request['end_date'] ?? null;
        $category      =$request['category'] ?? null;
        $amount        =$request['amount'] ?? null;


        return $query->when($category,function($query) use ($category){
            $query->where('budget_category_id',$category);
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
        })
        ->when($amount,function($query) use ($amount){
            if ($amount == "0-499999") {
                $query->whereBetween('amount',[0,499999]);
            }
            if ($amount == "500000-999999") {
                $query->whereIn('amount',[500000,999999]);
            }
            if ($amount == "1000000 +") {
                $query->where('amount','>=',1000000);
            }
        });
       
    }
}
