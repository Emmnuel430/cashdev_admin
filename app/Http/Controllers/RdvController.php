<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use App\Mail\RdvConfirmation;
use App\Mail\RdvNotification;

use Illuminate\Http\Request;
use App\Models\Rdv;
use Log;

class RdvController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            // Étape 1
            'client_nom' => 'required|string|max:100',
            'client_prenom' => 'nullable|string|max:100',
            'client_email' => 'nullable|email|max:255',
            'client_tel' => 'required|string|max:30',

            // Etape 2
            'commentaires' => 'nullable|string',
            'date_prise_rdv' => 'required|date',
        ]);

        $rdv = Rdv::create($validated);

        // Envoi email au client (si email renseigné)
        if (!empty($validated['client_email'])) {
            try {
                Mail::to($validated['client_email'])->send(new RdvConfirmation($rdv));
            } catch (\Exception $e) {
                Log::error('Erreur envoi mail : ' . $e->getMessage());
                return response()->json(['message' => "Prise de rendez-vous réussie, mais erreur lors de l'envoi du mail"], 200);
            }
        }

        // Envoi email à l'entreprise
        $entrepriseEmail = "emmanueldaho859@gmail.com";
        // $entrepriseEmail = "support@cashdev.africa";
        try {
            Mail::to($entrepriseEmail)->send(new RdvNotification($rdv));
        } catch (\Exception $e) {
            Log::error('Erreur envoi alerte mail : ' . $e->getMessage());
        }

        return response()->json(['message' => 'Rendez-vous enregistré avec succès.',/*  'rdv' => $rdv */], 201);
    }

    public function index()
    {
        $rdvs = Rdv::orderByDesc('created_at')->get();
        return response()->json($rdvs);
    }

    public function show($id)
    {
        $rdv = Rdv::find($id);

        if (!$rdv) {
            return response()->json(['message' => 'Rendez-vous introuvable.'], 404);
        }

        return response()->json($rdv);
    }

    public function destroy($id)
    {
        $rdv = Rdv::find($id);

        if (!$rdv) {
            return response()->json(['message' => 'Rendez-vous introuvable.'], 404);
        }

        $rdv->delete();

        return response()->json(['message' => 'Rendez-vous supprimé avec succès.', 'status' => 'deleted']);
    }
}
