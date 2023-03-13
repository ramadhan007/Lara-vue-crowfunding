<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;
use App\Traits\UsesUuid;
use Carbon\Carbon;


class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable, UsesUuid;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'photo_profile'
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

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function getJWTCustomClaims()
    {
        return[];
    }
    public function get_role_user(){
        $role = Role::where('name','user')->first();
        return $role->id;
    }
    public static function boot(){ 
        parent::boot();

        static::creating(function($model){
            $model->role_id =  $model->get_role_user();
        });

        static::created(function($model){
            $model->generate_otp_code();
        });
    }


    public function generate_otp_code(){
        do {
            $randomNumber = mt_rand(100000, 999999);
            $check = otp::where('otp',$randomNumber)->first(); 
        } while ($check);
        $now = Carbon::now();
        $otp_code = otp::updateOrCreate(
      ['user_id'=>$this->id],
      [ 'otp'=>$randomNumber,
        'valid_until'=>$now->addMinutes(5)
        ]);
    }
  

      
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    public function role()
    {
        return $this->belongsTo(Role::class,'role_id');
    }

    public function otp()
    {
         return $this->hasOne(otp::class, 'user_id');
    }

    public function isAdmin(){
        if($this->role){
            if($this->role->name == 'admin'){
                return true;
            }
        }
    }
}