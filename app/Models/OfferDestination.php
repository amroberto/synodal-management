<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\OfferPlan;

class OfferDestination extends Model
{
    protected $fillable = [
        'name',
        'description',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    /**
     * Plano de ofertas.
     */
    public function offerPlans(): HasMany
    {
        return $this->hasMany(OfferPlan::class);
    }
}
