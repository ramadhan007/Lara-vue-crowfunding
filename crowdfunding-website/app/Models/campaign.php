<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UsesUuid;

class campaign extends Model
{
    use HasFactory,UsesUuid;

    protected $fillable = ["title","description","address","image","required","collected"];

}
