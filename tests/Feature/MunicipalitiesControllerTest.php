<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Cache;
use App\Services\CacheService;


class MunicipalitiesControllerTest extends TestCase
{
    private $cacheService;
    public function setUp(): void
{
    parent::setUp();

    $this->cacheService = new CacheService();
}

    /**
     * Testa se a rota de listagem de municípios funciona corretamente.
     *
     * @return void
     */
    public function testMunicipalitiesListRoute()
    {
        $response = $this->get('/api/municipalities/RS');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data_provider',
            'municipalities',
            'current_page',
            'total',
            'per_page'
        ]);
    }

    /**
     * Testa se a rota de listagem de municípios retorna erro ao fornecer UF inválida.
     *
     * @return void
     */
    public function testInvalidUFReturnsError()
    {
        $response = $this->get('/api/municipalities/INVALID');

        $response->assertStatus(400);
        $response->assertJson([
            'error' => 'O parâmetro UF é inválido.'
        ]);
    }

    /**
     * Testa se a paginação de resultados está funcionando corretamente.
     *
     * @return void
     */
    public function testPagination()
    {
        $response = $this->get('/api/municipalities/RS?page=2');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data_provider',
            'municipalities',
            'current_page',
            'total',
            'per_page'
        ]);

        $response->assertJson(['current_page' => 2]);
    }

    /**
     * Testa se o número total de municípios retornado na resposta está correto.
     *
     * @return void
     */
    public function testTotalMunicipalitiesCount()
    {
        $response = $this->get('/api/municipalities/RS');

        $response->assertJson([
            'total' => 497, // Substitua com o número correto de municípios para RS
        ]);
    }

    /**
     * Testa se a quantidade de municípios retornada por página está correta.
     *
     * @return void
     */
    public function testPerPageCount()
    {
        $response = $this->get('/api/municipalities/RS');

        $response->assertJson([
            'per_page' => 10, // Substitua com o número correto de municípios por página
        ]);
    }

    /**
     * Testa se a rota retorna um erro ao fornecer um valor negativo para a página.
     *
     * @return void
     */
    public function testNegativePageReturnsError()
    {
        $response = $this->get('/api/municipalities/RS?page=-1');

        $response->assertStatus(400);
        $response->assertJson([
            'error' => 'O parâmetro page deve ser maior ou igual a 1.',
        ]);
    }

    /**
     * Testa se a rota retorna um erro ao fornecer a página zero.
     *
     * @return void
     */
    public function testZeroPageReturnsError()
    {
        $response = $this->get('/api/municipalities/RS?page=0');

        $response->assertStatus(400);
        $response->assertJson([
            'error' => 'O parâmetro page deve ser maior ou igual a 1.',
        ]);
    }


}
