<?php

declare(strict_types=1);

namespace App\Enums;

enum UnityTypeEnum: string
{
    case PREACHINGPOINT = 'preaching_point';
    case COMMUNITY = 'community';
    case PARISH = 'parish';
    case SYNOD = 'synod';
    case HEADQUARTERS = 'headquarters';
    case SUPPLIER = 'supplier';
    case INVESTMENT = 'investment';
    case OTHER = 'other';

    public static function getValues(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function values(): array
    {
        return array_map(fn($case) => $case->value, self::cases());
    }
    
    public static function getLabels(): array
    {
        return [
            self::PREACHINGPOINT->value => 'Ponto de Pregação',
            self::COMMUNITY->value => 'Comunidade',
            self::PARISH->value => 'Paróquia',
            self::SYNOD->value => 'Sínodo',
            self::HEADQUARTERS->value => 'Sede',
            self::SUPPLIER->value => 'Fornecedor',
            self::INVESTMENT->value => 'Investimento',
            self::OTHER->value => 'Outro',
        ];
    }

    public function label():string
    {
        return match ($this) {
            self::PREACHINGPOINT => 'Ponto de Pregação',
            self::COMMUNITY => 'Comunidade',
            self::PARISH => 'Paróquia',
            self::SYNOD => 'Sínodo',
            self::HEADQUARTERS => 'Sede',
            self::SUPPLIER => 'Fornecedor',
            self::INVESTMENT => 'Investimento',
            self::OTHER => 'Outro',
        };
    }
}
