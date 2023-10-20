<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use App\Services\CacheService;

class MunicipalitiesController extends Controller
{
    private $cacheService; // Adicione esta linha

    // Adicione este construtor
    public function __construct(CacheService $cacheService)
    {
        $this->cacheService = $cacheService;
    }


    /**
     * Retorna uma lista paginada de municípios de uma UF.
     *
     * @param string $uf Código da Unidade Federativa (ex: RS).
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($uf)
    {

        
        // Verifica se $uf possui o formato esperado (duas letras)
        if (!preg_match('/^[A-Za-z]{2}$/', $uf)) {
            return response()->json(['error' => 'O parâmetro UF é inválido.'], 400);
        }

        // Obtém o provedor de API a ser usado (brasilapi ou ibge)
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
        $municipalities = $this->cacheService->get($cacheKey);

        if (!$municipalities) {
            $client = new Client();
            try {
                $response = $client->get($apiUrl);
                $apiData = json_decode($response->getBody(), true);

                $municipalities = $this->formatApiData($apiData);

                $this->cacheService->put($cacheKey, $municipalities, 360);
            } catch (\GuzzleHttp\Exception\RequestException $e) {
                return response()->json(['error' => 'Erro na requisição para a API.'], 500);
            } catch (\Exception $e) {
                return response()->json(['error' => 'Ocorreu um erro ao processar a requisição.'], 500);
            }
        }

        // Implementação da paginação dos resultados
        if (!is_array($municipalities)) {
            return response()->json(['error' => 'Ocorreu um erro ao obter os dados.'], 500);
        }
        $this->cacheService->put($cacheKey, $municipalities, 360);
        $page = request('page', 1);
        
        if ($page < 1) {
            return response()->json(['error' => 'O parâmetro page deve ser maior ou igual a 1.'], 400);
        }
        $perPage = 10;
         $municipalitiesPaginated = collect($municipalities)->forPage($page, $perPage)->values();

        return response()->json([
            'data_provider' => $dataProvider,
            'municipalities' => $municipalitiesPaginated,
            'current_page' => $page,
            'total' => count($municipalities),
            'per_page' => $perPage
        ]);
    }

    /**
     * Formata os dados da API para o formato desejado.
     *
     * @param array $apiData Dados da API.
     * @return array
     */
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
