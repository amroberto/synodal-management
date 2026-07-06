<?php

namespace App\Models;

use App\Enums\UnityTypeEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Sector;

class Community extends Model
{
    protected $fillable = [
        'corporate_name',
        'fantasy_name',
        'cnpj',
        'unity_type',
        'sector_id',
        'cep',
        'street',
        'number',
        'complement',
        'neighborhood',
        'city',
        'state',
        'phone',
        'mobile',
        'email',
        'website'
    ];

    public $timestamps = true;

    protected $casts = [
        'unity_type' => UnityTypeEnum::class,
    ];

    /**
     * [Description for sector]
     *
     * @return BelongsTo
     * 
     */
    public function sector(): BelongsTo
    {
        return $this->belongsTo(Sector::class);
    }
}
