<?php

namespace Tests\Feature;

use App\Models\Listing;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ListingApiTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_new_listing()
    {
        $listingData = [
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
        ];

        $response = $this->postJson('/api/listings', $listingData);

        $response->assertStatus(201)
            ->assertJson([
                'success' => true
            ]);

        $this->assertDatabaseHas('listings', ['board' => 'ABC-1234']);
    }

    /** @test */
    public function it_can_list_all_listings()
    {
        Listing::factory()->count(3)->create();

        $response = $this->getJson('/api/listings');

        $response->assertStatus(200)
            ->assertJsonCount(3, 'data');
    }

    /** @test */
    public function it_can_show_a_specific_listing()
    {
        $listing = Listing::factory()->create();

        $response = $this->getJson('/api/listings/' . $listing->id);

        $response->assertStatus(200)
            ->assertJsonFragment([
                'board' => $listing->board
            ]);
    }

    /** @test */
    public function it_can_update_a_listing()
    {
        $listing = Listing::factory()->create();

        $updatedData = [
            'type' => 'Carro',
            'brand' => 'Tesla',
            'model' => 'Tesla',
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
        ];

        $response = $this->putJson('/api/listings/' . $listing->id, $updatedData);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true
            ]);

        $this->assertDatabaseHas('listings', ['board' => 'ABC-1234']);
    }

    /** @test */
    public function it_can_delete_a_listing()
    {
        $listing = Listing::factory()->create();

        $response = $this->deleteJson('/api/listings/' . $listing->id);

        $response->assertStatus(204);

        $this->assertDatabaseMissing('listings', ['id' => $listing->id]);
    }
}
