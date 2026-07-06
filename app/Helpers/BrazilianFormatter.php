<?php

namespace App\Helpers;

class BrazilianFormatter
{
    /**
     * Remove todos os caracteres não numéricos.
     */
    public static function clean(string|null $value): ?string
    {
        if ($value === null) {
            return null;
        }

        return preg_replace('/\D/', '', $value);
    }

    /**
     * Formata RG: 00.000.000-0
     */
    public static function formatRg(?string $value): ?string
    {
        $value = self::clean($value);
        if (!$value || strlen($value) !== 9) {
            return $value;
        }
        return preg_replace('/(\d{2})(\d{3})(\d{3})(\d{1})/', '$1.$2.$3-$4', $value);
    }

    /**
     * Formata CPF: 000.000.000-00
     */
    public static function formatCpf(?string $value): ?string
    {
        $value = self::clean($value);

        if (!$value || strlen($value) !== 11) {
            return $value;
        }

        return preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $value);
    }

    /**
     * Formata CNPJ: 00.000.000/0000-00
     */
    public static function formatCnpj(?string $value): ?string
    {
        $value = self::clean($value);

        if (!$value || strlen($value) !== 14) {
            return $value;
        }

        return preg_replace('/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/', '$1.$2.$3/$4-$5', $value);
    }

    /**
     * Formata CEP: 00000-000
     */
    public static function formatCep(?string $value): ?string
    {
        $value = self::clean($value);

        if (!$value || strlen($value) !== 8) {
            return $value;
        }

        return preg_replace('/(\d{5})(\d{3})/', '$1-$2', $value);
    }

    /**
     * Formata telefone fixo: (00) 0000-0000
     */
    public static function formatPhone(?string $value): ?string
    {
        $value = self::clean($value);

        if (!$value || strlen($value) !== 10) {
            return $value;
        }

        return preg_replace('/(\d{2})(\d{4})(\d{4})/', '($1) $2-$3', $value);
    }

    /**
     * Formata celular: (00) 00000-0000
     */
    public static function formatMobile(?string $value): ?string
    {
        $value = self::clean($value);

        if (!$value || strlen($value) !== 11) {
            return $value;
        }

        return preg_replace('/(\d{2})(\d{5})(\d{4})/', '($1) $2-$3', $value);
    }

    /**
     * Formata automaticamente telefone ou celular baseado no tamanho
     */
    public static function formatPhoneOrMobile(?string $value): ?string
    {
        $clean = self::clean($value);

        if (strlen($clean) === 11) {
            return self::formatMobile($value);
        }

        if (strlen($clean) === 10) {
            return self::formatPhone($value);
        }

        return $value;
    }
}