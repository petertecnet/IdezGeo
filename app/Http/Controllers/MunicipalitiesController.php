<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use GuzzleHttp\Client;

class MunicipalitiesController extends Controller
{
    public function index($uf)
    {
        $apiProvider = strtolower(env('API_PROVIDER', 'brasilapi'));

        if ($apiProvider === 'brasilapi') {
            $apiUrl = "https://brasilapi.com.br/api/ibge/municipios/v1/$uf";
            $dataProvider = 'BRASILAPI';
        } elseif ($apiProvider === 'ibge') {
            $apiUrl = "https://servicodados.ibge.gov.br/api/v1/localidades/estados/$uf/municipios";
            $dataProvider = 'IBGE';
        } else {
            // Em caso de API_PROVIDER inválido, usar a BRASILAPI por padrão
            $apiUrl = "https://brasilapi.com.br/api/ibge/municipios/v1/$uf";
            $dataProvider = 'BRASILAPI';
        }

        $cacheKey = 'municipios_' . $uf;
        $municipalities = Cache::get($cacheKey);

        if (!$municipalities) {
            $client = new Client();
            $response = $client->get($apiUrl);
            $apiData = json_decode($response->getBody(), true);

            $municipalities = $this->formatApiData($apiData);

            Cache::put($cacheKey, $municipalities, 360);
        }

        return response()->json(['data_provider' => $dataProvider, 'municipalities' => $municipalities]);
    }

    private function formatApiData($apiData)
    {
        $formattedData = [];

        foreach ($apiData as $municipality) {
            $formattedData[] = [
                'name' => $municipality['nome'],
                'ibge_code' => $municipality['codigo_ibge'],
            ];
        }

        return $formattedData;
    }
}
