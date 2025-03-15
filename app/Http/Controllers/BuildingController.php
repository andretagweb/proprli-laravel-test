<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBuildingRequest;
use App\Http\Requests\UpdateBuildingRequest;
use App\Http\Resources\BuildingResource;
use App\Repositories\BuildingRepository;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class BuildingController extends Controller
{
    protected BuildingRepository $buildingRepository;

    public function __construct(BuildingRepository $buildingRepository)
    {
        $this->buildingRepository = $buildingRepository;
    }

    public function index(): AnonymousResourceCollection
    {
        $perPage = request('per_page', 10);
        return BuildingResource::collection($this->buildingRepository->getAllBuildings($perPage));
    }

    public function store(StoreBuildingRequest $request): BuildingResource
    {
        $building = $this->buildingRepository->create($request->validated());
        return new BuildingResource($building);
    }

    public function show(string $id): BuildingResource
    {
        $building = $this->buildingRepository->findBuildingById($id);
        return new BuildingResource($building);
    }

    public function update(UpdateBuildingRequest $request, string $id): BuildingResource
    {
        $building = $this->buildingRepository->findBuildingById($id);
        $updatedBuilding = $this->buildingRepository->update($building, $request->validated());
        return new BuildingResource($updatedBuilding);
    }

    public function destroy(string $id)
    {
        $building = $this->buildingRepository->findBuildingById($id);
        $this->buildingRepository->delete($building);
        return response()->json(['message' => 'Building deleted successfully'], 204);
    }
}
