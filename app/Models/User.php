<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles; 
use App\Models\Management\Account;
use App\Models\Management\Ledger;
use App\Models\Management\Budget;
use Auth;
use Str;
use Hash;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable,HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'status',
        'phone_number',
        'remarks',
        'uuid',
        'created_by'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function accounts(){
        return $this->hasMany(Account::class,'user_id','id');
    }

    public function ledgers(){
        return $this->hasMany(Ledger::class,'user_id','id');
    }

    public function budgets(){
        return $this->hasMany(Budget::class,'user_id','id');
    }

    public static function store($user_data){
       
        $user =User::create([
            'name'         =>ucwords($user_data['first_name'].' '.$user_data['middle_name'].' '.$user_data['last_name']),
            'username'     =>$user_data['username'],
            'phone_number' =>$user_data['phone_number'],
            'created_by'   =>Auth::user()->id ?? null,
            'uuid'         =>(string)Str::orderedUuid(),
            'password'     =>Hash::make('Act2023'),
        ]);

        return $user;
    }

    public function scopeWithFilters($query,$request){
        $start_date    =$request['start_date'] ?? null;
        $end_date      =$request['end_date'] ?? null;
        $phone_number  =$request['phone_number'] ?? null;
        $device_type    =$request['device_type'] ?? null;


        return $query->when($phone_number,function($query) use ($phone_number){
            $query->where('phone','like','%'.$phone_number.'%');
        })
        ->when($device_type,function($query) use ($device_type){
            $query->where('device_type',$device_type);
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
