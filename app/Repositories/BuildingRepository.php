<?php

namespace App\Repositories;

use App\Models\Building;

class BuildingRepository extends BaseRepository
{
    public function __construct(Building $building)
    {
        parent::__construct($building);
    }

    public function getAllBuildings(int $perPage = 10)
    {
        return $this->model->with('tasks')->paginate($perPage);
    }

    public function findBuildingById(string $id)
    {
        return $this->model->with('tasks')->findOrFail($id);
    }
}
