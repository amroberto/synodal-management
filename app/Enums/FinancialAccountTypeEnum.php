<?php

namespace App\Enums;

enum FinancialAccountTypeEnum: string
{
    case DINHEIRO = 'dinheiro';
    case BANCO = 'banco';
    case CARTAO = 'cartao';
    case INVESTIMENTO = 'investimento';

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
            self::DINHEIRO->value => 'Dinheiro',
            self::BANCO->value => 'Banco',
            self::CARTAO->value => 'Cartão',
            self::INVESTIMENTO->value => 'Investimento',
        ];
    }

    public function label(): string
    {
        return match ($this) {
            self::DINHEIRO => 'Dinheiro',
            self::BANCO => 'Banco',
            self::CARTAO => 'Cartão',
            self::INVESTIMENTO => 'Investimento',
        };
    }
}
