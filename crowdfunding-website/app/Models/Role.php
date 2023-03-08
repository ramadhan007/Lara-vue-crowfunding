
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class Role extends Model
{
    use HasFactory;
    protected $fillable=['name'];
    protected $keyType = 'string';
    public $incrementing = false;

    protected static function boot()
    {

        parent::boot();

        static::creating(function($model){
            if(empty($model->{$model->getKeyName()})){
                $model->{$model->getKeyName()}== Str::uuid();
            }
    });
   }

   public function role()
   {
        return $this->hasMany(User::class, 'role_id');
   }
}
     

