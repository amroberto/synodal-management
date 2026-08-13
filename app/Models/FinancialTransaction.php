<?php

namespace App\Models;

use App\Enums\FinancialTransactionTypeEnum;
use Illuminate\Database\Eloquent\Model;

class FinancialTransaction extends Model
{
    protected $fillable = [
        'financial_account_id',
        'transaction_date',
        'type',
        'description',
        'amount',
        'account_plan_id',
        'cost_center_id',
        'offer_plan_id',
        'notes',
    ];

    protected $casts = [
        'transaction_date' => 'date:Y-m-d',
        'type' => FinancialTransactionTypeEnum::class,
        'amount' => 'decimal:2',
    ];

    public function financialAccount()
    {
        return $this->belongsTo(FinancialAccount::class);
    }
}
