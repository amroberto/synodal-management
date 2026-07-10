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

    public function parent()
    {
        return $this->belongsTo(AccountPlan::class, 'parent_code', 'code');
    }
}
