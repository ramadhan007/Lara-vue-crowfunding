<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UsesUuid;


class Role extends Model
{
    use HasFactory, UsesUuid;
    protected $fillable=['name'];
    public function role()
   {
        return $this->hasMany(User::class, 'role_id');
   }
}
     