<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    public function getFullDescriptionAttribute(): string
    {
        return "{$this->code} - {$this->description}";
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(
            AccountPlan::class,
            'parent_code',
            'code'
        );
    }

    public function children(): HasMany
    {
        return $this->hasMany(
            AccountPlan::class,
            'parent_code',
            'code'
        );
    }
}
