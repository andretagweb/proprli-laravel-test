<?php

namespace App\Http\Controllers;

use App\Models\Building;
use Illuminate\Http\Request;

class BuildingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Building::with('tasks')->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
        ]);

        $building = Building::create($request->all());

        return response()->json($building, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return response()->json(Building::with('tasks')->findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $building = Building::findOrFail($id);

        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'address' => 'nullable|string',
        ]);

        $building->update($request->all());

        return response()->json($building);
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
