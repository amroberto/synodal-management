<?php

namespace App\Enums;

enum GenderEnum: string
{
    case MALE = 'Male';

    case FEMALE = 'Female';

    case OTHER = 'Other';

    public static function values(): array
    {
        return array_map(fn($case) => $case->value, self::cases());
    }
    
    public static function getValues(): array
    {
        return array_column(self::cases(), 'value');
    }

        public static function getLabels(): array
    {
        return [
            self::MALE->value => 'Masculino',
            self::FEMALE->value => 'Feminino',
            self::OTHER->value => 'Outros',
        ];
    }
}
