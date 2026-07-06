<?php

namespace App\Traits;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

trait GetAddressByCepTrait
{
    /**
     * Busca endereço via ViaCEP e preenche as propriedades do componente
     */
    public function getAddressByCep(string $cepProperty = 'cep')
    {
        // Remove máscara e valida
        $rawCep = preg_replace('/\D/', '', $this->{$cepProperty});

        if (strlen($rawCep) !== 8) {
            $this->addError($cepProperty, 'CEP deve conter 8 dígitos.');
            return;
        }

        // Salva o CEP limpo no banco (sem máscara)
        $this->{$cepProperty} = $rawCep;

        try {
            /** @var \Illuminate\Http\Client\Response $response */
            $response = Http::get("https://viacep.com.br/ws/{$rawCep}/json/");

            if ($response->failed()) {
                $this->addError($cepProperty, 'CEP não encontrado.');
                return;
            }

            $data = $response->json();

            if (($data['erro'] ?? false)) {
                $this->addError($cepProperty, 'CEP não encontrado.');
                return;
            }

            // Preenche os campos do componente (ajuste nomes se necessário)
            $this->street       = $data['logradouro'] ?? '';
            $this->neighborhood = $data['bairro'] ?? '';
            $this->city         = $data['localidade'] ?? '';
            $this->state        = $data['uf'] ?? '';
            // $this->ibge_code  = $data['ibge'] ?? ''; // se usar

            $this->resetErrorBag($cepProperty);

        } catch (\Exception $e) {
            Log::error('Erro ViaCEP: ' . $e->getMessage());
            $this->addError($cepProperty, 'Erro ao buscar CEP. Tente novamente.');
        }
    }
}
