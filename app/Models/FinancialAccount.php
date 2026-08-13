<?php

namespace App\Models;

use App\Enums\FinancialAccountTypeEnum;
use Illuminate\Database\Eloquent\Model;

class FinancialAccount extends Model
{
    protected $fillable = [
        'code',
        'name',
        'type',
        'bank_name',
        'agency',
        'account_number',
        'initial_balance',
        'current_balance',
        'active',
    ];

    protected $casts = [
        'initial_balance' => 'decimal:2',
        'current_balance' => 'decimal:2',
        'type' => FinancialAccountTypeEnum::class,
        'active' => 'boolean',
    ];
}
