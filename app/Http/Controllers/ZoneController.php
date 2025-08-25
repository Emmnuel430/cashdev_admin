<?php

namespace App\Http\Controllers;

use App\Models\Zone;
use Illuminate\Http\Request;

class ZoneController extends Controller
{
    public function index()
    {
        return response()->json(Zone::all());
    }
    public function listPublic()
    {
        return response()->json(Zone::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'ville' => 'required|string|max:255',
            'pays' => 'required|string|max:255',
            'techniciens' => 'required|integer|min:0',
            'delai_moyen' => 'nullable|string|max:50',
        ]);

        $zone = Zone::create($validated);

        return response()->json([
            'message' => 'Zone créée avec succès',
            'data' => $zone
        ], 201);
    }

    public function show($id)
    {
        $zone = Zone::findOrFail($id);
        return response()->json($zone);
    }

    public function update(Request $request, $id)
    {
        $zone = Zone::findOrFail($id);

        $validated = $request->validate([
            'ville' => 'required|string|max:255',
            'pays' => 'required|string|max:255',
            'techniciens' => 'required|integer|min:0',
            'delai_moyen' => 'nullable|string|max:50',
        ]);

        $zone->update($validated);

        return response()->json([
            'message' => 'Zone mise à jour avec succès',
            'data' => $zone
        ]);
    }

    public function destroy($id)
    {
        $zone = Zone::findOrFail($id);
        $zone->delete();

        return response()->json([
            'message' => 'Zone supprimée avec succès',
            'status' => 'deleted'
        ]);
    }
}
