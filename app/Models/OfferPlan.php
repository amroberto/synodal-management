<?php

namespace App\Models;

use App\Enums\OfferInstanceEnum;
use App\Models\AccountPlan;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OfferPlan extends Model
{
    protected $fillable = [
        'offer_date',
        'liturgical_date',
        'offer_instance',
        'offer_destination_id',
        'account_plan_id',
        'cost_center_id',
        'active',
    ];

    protected $casts = [
        'offer_date'     => 'date',
        'offer_instance' => OfferInstanceEnum::class,
        'active'         => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function costCenter(): BelongsTo
    {
        return $this->belongsTo(CostCenter::class);
    }

    public function offerDestination(): BelongsTo
    {
        return $this->belongsTo(
            OfferDestination::class,
            'offer_destination_id'
        );
    }

    public function accountPlan(): BelongsTo
    {
        return $this->belongsTo(AccountPlan::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Query Scopes
    |--------------------------------------------------------------------------
    */

    /**
     * Somente registros ativos.
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('active', true);
    }

    /**
     * Filtrar por ano.
     */
    public function scopeYear(Builder $query, int $year): Builder
    {
        return $query->whereYear('offer_date', $year);
    }

    /**
     * Filtrar por mês.
     */
    public function scopeMonth(Builder $query, int $month): Builder
    {
        return $query->whereMonth('offer_date', $month);
    }

    /**
     * Filtrar por mês e ano.
     */
    public function scopePeriod(
        Builder $query,
        int $month,
        int $year
    ): Builder {

        return $query
            ->whereMonth('offer_date', $month)
            ->whereYear('offer_date', $year);
    }

    /**
     * Filtrar por instância.
     */
    public function scopeInstance(
        Builder $query,
        OfferInstanceEnum $instance
    ): Builder {

        return $query->where(
            'offer_instance',
            $instance
        );
    }

    /**
     * Ordena pelo dia da oferta.
     */
    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('offer_date', 'asc');
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function getMonthAttribute(): int
    {
        return $this->offer_date->month;
    }

    public function getYearAttribute(): int
    {
        return $this->offer_date->year;
    }
}