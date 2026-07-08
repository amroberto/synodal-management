<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\AccountPlan;
class AccountPlan extends Model
{
    protected $fillable = [
        'code',
        'description',
        'level',
        'parent_code',
        'active',
    ];
}
