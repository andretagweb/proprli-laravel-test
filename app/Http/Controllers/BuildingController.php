<?php

namespace App\Http\Controllers;

use App\Models\Building;
use App\Http\Requests\StoreBuildingRequest;
use App\Http\Requests\UpdateBuildingRequest;
use App\Http\Resources\BuildingResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class BuildingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        $perPage = request('per_page', 10);
        return BuildingResource::collection(Building::with('tasks')->paginate($perPage));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBuildingRequest $request): BuildingResource
    {
        $building = Building::create($request->validated());

        return new BuildingResource($building);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): BuildingResource
    {
        $building = Building::with('tasks')->findOrFail($id);

        return new BuildingResource($building);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBuildingRequest $request, string $id): BuildingResource
    {
        $building = Building::findOrFail($id);
        $building->update($request->validated());

        return new BuildingResource($building);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $building = Building::findOrFail($id);
        $building->delete();

        return response()->json(['message' => 'Building deleted successfully'], 204);
    }
}
