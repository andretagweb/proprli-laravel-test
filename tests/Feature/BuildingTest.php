<?php

namespace Tests\Feature;

use App\Models\Building;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BuildingTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function it_can_create_a_building()
    {
        $data = [
            'name' => 'Empire State',
            'address' => 'New York'
        ];

        $response = $this->postJson('/api/buildings', $data);

        $response->assertStatus(201)
                 ->assertJson([
                     'data' => [
                         'name' => $data['name'],
                         'address' => $data['address']
                     ]
                 ]);

        $this->assertDatabaseHas('buildings', $data);
    }

    /** @test */
    public function it_can_list_buildings()
    {
        $buildings = Building::factory()->count(2)->create();

        $response = $this->getJson('/api/buildings');

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data' => [
                         '*' => ['id', 'name', 'address', 'created_at', 'updated_at']
                     ],
                     'links',
                     'meta'
                 ])
                 ->assertJsonFragment(['name' => $buildings->first()->name]);
    }

    /** @test */
    public function it_can_get_a_single_building()
    {
        $building = Building::factory()->create();

        $response = $this->getJson("/api/buildings/{$building->id}");

        $response->assertStatus(200)
                 ->assertJson([
                     'data' => [
                         'id' => $building->id,
                         'name' => $building->name,
                         'address' => $building->address
                     ]
                 ]);
    }

    /** @test */
    public function it_can_update_a_building()
    {
        $building = Building::factory()->create();

        $updatedData = [
            'name' => 'Updated Name',
            'address' => 'Updated Address'
        ];

        $response = $this->putJson("/api/buildings/{$building->id}", $updatedData);

        $response->assertStatus(200)
                 ->assertJson([
                     'data' => [
                         'id' => $building->id,
                         'name' => 'Updated Name',
                         'address' => 'Updated Address'
                     ]
                 ]);

        $this->assertDatabaseHas('buildings', ['id' => $building->id, 'name' => 'Updated Name']);
    }

    /** @test */
    public function it_can_delete_a_building()
    {
        $building = Building::factory()->create();

        $response = $this->deleteJson("/api/buildings/{$building->id}");

        $response->assertStatus(204);

        $this->assertDatabaseMissing('buildings', ['id' => $building->id]);
    }
}
