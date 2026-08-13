<?php

namespace App\Models;

use App\Models\Community;
use App\Models\Entity;
use App\Models\Position;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Leadership extends Model
{
    /** @use HasFactory<\Database\Factories\LeadershipFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'cpf',
        'rg',
        'entity_id',
        'birthdate',
        'is_active',
        'gender',
        'mobile',
        'business_phone',
        'phone',
        'email',
        'photo',
        'cep',
        'street',
        'number',
        'complement',
        'neighborhood',
        'city',
        'state'
    ];

    protected function casts(): array
    {
        return [
            'birthdate' => 'date',
            'is_active' => 'boolean',
            'gender' => 'string',
        ];
    }

    /**
     * [Description for positions]
     *
     * @return BelongsToMany
     * 
     */
    public function positions(): BelongsToMany
    {
        return $this->belongsToMany(Position::class, 'community_leaderships')
            ->withTimestamps();
    }

    /**
     * [Description for community]
     *
     * @return BelongsTo
     * 
     */
    public function entity(): BelongsTo
    {
        return $this->belongsTo(Entity::class);
    }

    /**
     * Relacionamento inverso: Comunidades que esta liderança faz parte
     */
    public function entities(): BelongsToMany
    {
        return $this->belongsToMany(Entity::class, 'entity_leaderships')
                    ->withPivot('id', 'position_id')
                    ->withTimestamps();
    }
}