<?php

namespace App\Models;

use App\Enums\UnityTypeEnum;
use App\Models\Leadership;
use App\Models\Sector;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Entity extends Model
{
    /** @use HasFactory<\Database\Factories\CommunityFactory> */
    use HasFactory;

    protected $fillable = [
        'corporate_name',
        'fantasy_name',
        'cnpj',
        'unity_type',
        'cep',
        'street',
        'number',
        'complement',
        'neighborhood',
        'city',
        'state',
        'sector_id',
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
     * Relacionamento com as Lideranças através da tabela pivô
     */
    public function leaderships(): BelongsToMany
    {
        return $this->belongsToMany(Leadership::class, 'entity_leaderships')
                    ->withPivot('id', 'position_id') // Traz o ID da tabela pivô e o cargo junto
                    ->withTimestamps();
    }

    /**
     * [Description for entity]
     *
     * @return BelongsTo
     * 
     */
    public function sector(): BelongsTo
    {
        return $this->belongsTo(Sector::class);
    }
}
