<?php

namespace App\Traits;

use Illuminate\Support\Facades\File;

trait ImportsCsv
{
    /**
     * Importa um arquivo CSV e retorna um array associativo.
     *
     * @param string $path
     * @param string $delimiter
     * @return array
     *
     * @throws \Exception
     */
    public function importCsv(string $path, string $delimiter = ','): array
    {
        if (! File::exists($path)) {
            throw new \Exception("Arquivo não encontrado: {$path}");
        }

        $rows = [];

        $handle = fopen($path, 'r');

        if ($handle === false) {
            throw new \Exception("Não foi possível abrir o arquivo: {$path}");
        }

        /*
         * Lê o cabeçalho
         */
        $header = fgetcsv($handle, 0, $delimiter);

        /*
         * Remove BOM UTF-8, converte para minúsculas
         * e troca espaços por underline.
         */
        $header = array_map(function ($column) {

            $column = preg_replace('/^\xEF\xBB\xBF/', '', $column);

            return str($column)
                ->trim()
                ->lower()
                ->replace(' ', '_')
                ->toString();

        }, $header);

        /*
         * Lê as linhas do arquivo
         */
        while (($data = fgetcsv($handle, 0, $delimiter)) !== false) {

            // Ignora linhas vazias
            if (count(array_filter($data)) === 0) {
                continue;
            }

            $rows[] = array_combine($header, $data);
        }

        fclose($handle);

        return $rows;
    }
}