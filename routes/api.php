<?php

use App\Http\Controllers\RdvController;
use App\Http\Controllers\RubriqueController;
use App\Http\Controllers\ZoneController;
use App\Models\Subsection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\SettingController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return response()->json(['user' => $request->user()]);
    ;
});

Route::post('login', [UserController::class, 'login']);


Route::middleware('auth:sanctum')->group(function () {
    // --------------------------------
    Route::middleware('auth:sanctum')->post('/logout', function (Request $request) {
        $token = $request->user()->currentAccessToken();

        if ($token && method_exists($token, 'delete')) {
            $token->delete();
        }

        return response()->json(['message' => 'Déconnecté']);
    });


    Route::post('add_user', [UserController::class, 'addUser']);
    Route::get('liste_user', [UserController::class, 'listeUser']);
    Route::get('user/{id}', [UserController::class, 'getUser']);
    Route::post('update_user/{id}', [UserController::class, 'updateUser']);
    Route::delete('delete_user/{id}', [UserController::class, 'deleteUser']);

    // Pages
    Route::prefix('pages')->group(function () {
        Route::post('/', [PageController::class, 'store']);
        Route::get('/', [PageController::class, 'index']);
        Route::get('/{id}', [PageController::class, 'get']);
        Route::post('/{id}', [PageController::class, 'update']);
        Route::delete('/{id}', [PageController::class, 'destroy']);
    });

    Route::prefix('zones')->group(function () {
        Route::post('/', [ZoneController::class, 'store']);
        Route::get('/', [ZoneController::class, 'index']);
        Route::get('/{id}', [ZoneController::class, 'show']);
        Route::post('/{id}', [ZoneController::class, 'update']);
        Route::delete('/{id}', [ZoneController::class, 'destroy']);
    });

    Route::prefix('rubriques')->group(function () {
        Route::post('/', [RubriqueController::class, 'store']);
        Route::get('/', [RubriqueController::class, 'index']);
        Route::get('/{id}', [RubriqueController::class, 'show']);
        Route::post('/{id}', [RubriqueController::class, 'update']);
        Route::delete('/{id}', [RubriqueController::class, 'destroy']);
    });

    Route::prefix('settings')->group(function () {
        Route::get('/', [SettingController::class, 'index']);
        Route::post('/', [SettingController::class, 'update']);
        Route::post('/add', [SettingController::class, 'store']);
    });

    Route::get('/rdvs', [RdvController::class, 'index']);
    Route::get('/rdvs/{id}', [RdvController::class, 'show']);
    Route::delete('/rdvs/{id}', [RdvController::class, 'destroy']);

});

Route::post('/rdvs', [RdvController::class, 'store']);

Route::get('/settings-public', [SettingController::class, 'index']);

Route::get('/pages-public', [PageController::class, 'listPublic']);
Route::get('/pages-accueil', [PageController::class, 'showAccueil']);

Route::get('/rubriques-public', [RubriqueController::class, 'listPublic']);
Route::get('/zones-public', [ZoneController::class, 'listPublic']);
Route::get('/pages-public/{slug}', [PageController::class, 'getBySlug']);

Route::get('/pages-public-by-template', [PageController::class, 'getByTemplate']);



// --------------
Route::get('/subsections/{id}', function ($id) {
    return Subsection::findOrFail($id);
});