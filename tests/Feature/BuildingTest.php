<?php

namespace Tests\Feature;

use App\Models\Building;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class BuildingTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test creating a building.
     */
    #[Test]
    public function it_can_create_a_building()
    {
        $response = $this->postJson('/api/buildings', [
            'name' => 'Empire State',
            'address' => 'New York'
        ]);

        $response->assertStatus(201)
                 ->assertJsonStructure(['id', 'name', 'address']);

        $this->assertDatabaseHas('buildings', ['name' => 'Empire State']);
    }

    /**
     * Test listing buildings.
     */
    #[Test]
    public function it_can_list_buildings()
    {
        Building::factory()->count(2)->create();

        $response = $this->getJson('/api/buildings');

        $response->assertStatus(200)
                 ->assertJsonCount(2);
    }

    /**
     * Test getting a single building.
     */
    #[Test]
    public function it_can_get_a_single_building()
    {
        $building = Building::factory()->create();

        $response = $this->getJson("/api/buildings/{$building->id}");

        $response->assertStatus(200)
                 ->assertJsonFragment(['name' => $building->name]);
    }

    /**
     * Test updating a building.
     */
    #[Test]
    public function it_can_update_a_building()
    {
        $building = Building::factory()->create();

        $response = $this->putJson("/api/buildings/{$building->id}", [
            'name' => 'Updated Name',
            'address' => 'Updated Address'
        ]);

        $response->assertStatus(200)
                 ->assertJsonFragment(['name' => 'Updated Name']);

        $this->assertDatabaseHas('buildings', ['name' => 'Updated Name']);
    }

    /**
     * Test deleting a building.
     */
    #[Test]
    public function it_can_delete_a_building()
    {
        $building = Building::factory()->create();

        $response = $this->deleteJson("/api/buildings/{$building->id}");

        $response->assertStatus(204);

        $this->assertDatabaseMissing('buildings', ['id' => $building->id]);
    }
}
