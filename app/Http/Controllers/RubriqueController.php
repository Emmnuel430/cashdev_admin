<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rubrique;


class RubriqueController extends Controller
{
    // Liste toutes les rubriques
    public function index()
    {
        return response()->json(Rubrique::all());
    }
    public function listPublic()
    {
        return response()->json(Rubrique::all());
    }

    // Crée une nouvelle rubrique
    public function store(Request $request)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'plage_support' => 'nullable|string',
            'tti_ttr' => 'nullable|string',
            'preventif' => 'nullable|string',
            'pieces_conso' => 'nullable|string',
            'reporting' => 'nullable|string',
        ]);

        $rubrique = Rubrique::create($validated);

        return response()->json([
            'message' => 'Rubrique créée avec succès',
            'data' => $rubrique
        ], 201);
    }

    // Affiche une rubrique spécifique
    public function show($id)
    {
        $rubrique = Rubrique::findOrFail($id);
        return response()->json($rubrique);
    }

    // Met à jour une rubrique
    public function update(Request $request, $id)
    {
        $rubrique = Rubrique::findOrFail($id);

        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'plage_support' => 'nullable|string',
            'tti_ttr' => 'nullable|string',
            'preventif' => 'nullable|string',
            'pieces_conso' => 'nullable|string',
            'reporting' => 'nullable|string',
        ]);

        $rubrique->update($validated);

        return response()->json([
            'message' => 'Rubrique mise à jour avec succès',
            'data' => $rubrique
        ]);
    }

    // Supprime une rubrique
    public function destroy($id)
    {
        $rubrique = Rubrique::findOrFail($id);
        $rubrique->delete();

        return response()->json([
            'message' => 'Rubrique supprimée avec succès',
            'status' => 'deleted'
        ]);
    }
}
