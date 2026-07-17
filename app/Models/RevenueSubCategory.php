<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\RevenueCategory;

class RevenueSubCategory extends Model
{
    protected $fillable = [
        'revenue_category_id',
        'name',
        'description',
        'active',
    ];

    public function revenueCategory(): BelongsTo
    {
        return $this->belongsTo(RevenueCategory::class);
    }
}
