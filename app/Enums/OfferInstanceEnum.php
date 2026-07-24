<?php

namespace App\Enums;

enum OfferInstanceEnum: string
{
    case LOCAL = 'local';
    case SINODAL = 'sinodal';
    case NATIONAL = 'national';
    case ESPECIAL = 'especial';

    /**
     * Nome amigável.
     */
    public function label(): string
    {
        return match ($this) {
            self::LOCAL => 'Local',
            self::SINODAL => 'Sinodal',
            self::NATIONAL => 'Nacional',
            self::ESPECIAL => 'Especial';
        };
    }

    /**
     * Opções para Select.
     */
    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn (self $item) => [
                $item->value => $item->label(),
            ])
            ->toArray();
    }

    /**
     * Cor para badges.
     */
    public function color(): string
    {
        return match ($this) {
            self::LOCAL => 'zinc',
            self::SINODAL => 'blue',
            self::NATIONAL => 'green',
            self::ESPECIAL => 'cyan',
        };
    }
}
