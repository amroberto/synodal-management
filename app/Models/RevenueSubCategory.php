<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RevenueSubCategory extends Model
{
    protected $fillable = [
        'revenue_category_id',
        'account_plan_id',
        'name',
        'description',
        'active',
    ];

    public function revenueCategory(): BelongsTo
    {
        return $this->belongsTo(RevenueCategory::class);
    }

    public function accountPlan(): BelongsTo
    {
        return $this->belongsTo(AccountPlan::class);
    }
}
