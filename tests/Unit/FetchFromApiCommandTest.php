<?php

namespace Tests\Unit;

use App\Models\Listing;
use Tests\TestCase;
use Illuminate\Support\Facades\Http;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FetchFromApiCommandTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_updates_existing_records()
    {
        // Cria um registro existente no banco de dados
        Listing::create([
            'id' => 555,
            'type' => 'Carro',
            'brand' => 'Honda',
            'model' => 'Civic',
            'version' => 'LX',
            'year_model' => 2023,
            'year_build' => 2022,
            'doors' => 4,
            'board' => 'ABC-1234',
            'chassi' => '9BWzzz8M2K8zzzzz',
            'transmission' => 'Automática',
            'km' => 15000,
            'description' => 'Veículo em excelente estado de conservação, único dono.',
            'created' => '2023-01-15',
            'updated' => '2023-01-20',
            'sold' => false,
            'category' => 'Sedan',
            'url_car' => 'https://exemplo.com/honda-civic',
            'price' => 120000.00,
            'old_price' => null,
            'color' => 'Preto',
            'fuel' => 'Flex',
        ]);

        // Simula uma resposta da API com o mesmo item, mas com dados atualizados
        Http::fake([
            'https://hub.alpes.one/api/v1/integrator/export/1902' => Http::response([
                'data' => [
                    [
                        'id' => 123,
                        'type' => 'Carro',
                        'brand' => 'Honda',
                        'model' => 'Civic',
                        'version' => 'LX',
                        'year_model' => 2023,
                        'year_build' => 2022,
                        'doors' => 4,
                        'board' => 'ABC-1234',
                        'chassi' => '9BWzzz8M2K8zzzzz',
                        'transmission' => 'Automática',
                        'km' => 15000,
                        'description' => 'Veículo em excelente estado de conservação, único dono.',
                        'created' => '2023-01-15',
                        'updated' => '2023-01-20',
                        'sold' => false,
                        'category' => 'Sedan',
                        'url_car' => 'https://exemplo.com/honda-civic',
                        'price' => 120000.00,
                        'old_price' => null,
                        'color' => 'Preto',
                        'fuel' => 'Flex',
                    ]
                ]
            ], 200)
        ]);

        // Executa o comando novamente
        $this->artisan('app:fetch-from-api')->assertExitCode(0);

        // Verifica se o registro foi atualizado e não duplicado
        $this->assertDatabaseHas('listings', ['board' => 'ABC-1234']);
        $this->assertEquals(1, Listing::count());
    }
}
