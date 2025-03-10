<?php

namespace Tests\Feature;

use App\Models\Building;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BuildingTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_building()
    {
        $response = $this->postJson('/api/buildings', [
            'name' => 'Empire State',
            'address' => 'New York'
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('buildings', ['name' => 'Empire State']);
    }

    /** @test */
    public function it_can_list_buildings()
    {
        Building::factory()->count(2)->create();

        $response = $this->getJson('/api/buildings');

        $response->assertStatus(200)
                 ->assertJsonCount(2);
    }
}
