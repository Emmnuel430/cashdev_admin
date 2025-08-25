<?php
namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{

    public function store(Request $request)
    {
        $validated = $request->validate([
            'key' => 'required|string',
            'type' => 'required|in:text,file',
            'categorie' => 'nullable|string',
        ]);

        // Formatage automatique de la clé
        $key = strtolower(str_replace(' ', '_', $validated['key']));

        // Si la clé existe déjà, on l'ignore
        if (Setting::where('key', $key)->exists()) {
            return response()->json([
                'status' => 'exists',
                'message' => 'Cette clé existe déjà.',
            ], 409);
        }

        $setting = Setting::create([
            'key' => $key,
            'type' => $validated['type'],
            'categorie' => $validated['categorie'] ?? 'general',
            'value' => '',
        ]);

        return response()->json([
            'status' => 'success',
            'setting' => $setting,
        ]);
    }


    // 🔍 Liste des paramètres
    public function index()
    {
        return response()->json(Setting::all());
    }

    // 🛠️ Mise à jour des paramètres existants uniquement
    public function update(Request $request)
    {
        $updatedSettings = [];

        foreach ($request->all() as $key => $value) {
            // Récupérer le type envoyé (text ou file)
            $typeKey = $key . '_type';
            $type = $request->get($typeKey, 'text');

            $setting = Setting::where('key', $key)->first();

            if (!$setting) {
                continue; // clé inconnue, on ignore
            }

            if ($type === 'file' && $request->hasFile($key)) {
                $newPath = $request->file($key)->store('settings', 'public');

                if ($setting->value && Storage::disk('public')->exists($setting->value)) {
                    Storage::disk('public')->delete($setting->value);
                }

                $setting->update(['value' => $newPath]);
            } elseif ($type === 'text') {
                $setting->update(['value' => $value]);
            }

            $updatedSettings[] = $setting;
        }

        return response()->json([
            'status' => 'updated',
            'updated' => $updatedSettings,
        ]);
    }

}
