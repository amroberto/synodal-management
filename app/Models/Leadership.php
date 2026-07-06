<?php

namespace App\Models;

use App\Models\Address;
use App\Models\Position;
use App\Models\Community;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Leadership extends Model
{
    /** @use HasFactory<\Database\Factories\LeadershipFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'cpf',
        'rg',
        'community_id',
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
     * [Description for communities]
     *
     * @return BelongsToMany
     * 
     */
    public function communities(): BelongsToMany
    {
        return $this->belongsToMany(Community::class, 'community_leadership')
            ->withPivot('position_id')
            ->withTimestamps();
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
    public function community(): BelongsTo
    {
        return $this->belongsTo(Community::class);
    }

}
