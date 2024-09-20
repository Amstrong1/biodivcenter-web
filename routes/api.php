<?php

use App\Models\Pen;
use App\Models\User;

use App\Models\Animal;
use App\Models\Specie;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\IndividuController;
use App\Http\Controllers\API\RelocationController as APIRelocationController;
use App\Http\Controllers\API\ObservationController as APIObservationController;
use App\Http\Controllers\API\AlimentationController as APIAlimentationController;
use App\Http\Controllers\API\ReproductionController as APIReproductionController;
use App\Http\Controllers\API\SanitaryStateController as APISanitaryStateController;

Route::get('/user/{id}', function () {
    $user = User::where('id', request('id'))
        ->select('id', 'name', 'email', 'organization', 'contact', 'picture', 'role', 'ong_id')
        ->get()
        ->append('role_label')
        ->append('country');
    return response()->json($user, 200);
});

Route::post('/signin', [AuthController::class, 'signin']);

Route::get('/individus/{site_id}', [IndividuController::class, 'index']);
Route::post('/individu', [IndividuController::class, 'store']);
Route::get('/individu/{id}', [IndividuController::class, 'show']);
Route::post('/individu/{id}', [IndividuController::class, 'update']);
Route::delete('/individu/{id}', [IndividuController::class, 'destroy']);

Route::get('/api-sanitary-states/{site_id}', [APISanitaryStateController::class, 'index']);
Route::post('/api-sanitary-state', [APISanitaryStateController::class, 'store']);
Route::get('/api-sanitary-state/{id}', [APISanitaryStateController::class, 'show']);
Route::post('/api-sanitary-state/{id}', [APISanitaryStateController::class, 'update']);
Route::delete('/api-sanitary-state/{id}', [APISanitaryStateController::class, 'destroy']);

Route::get('/api-alimentations/{site_id}', [APIAlimentationController::class, 'index']);
Route::post('/api-alimentation', [APIAlimentationController::class, 'store']);
Route::get('/api-alimentation/{id}', [APIAlimentationController::class, 'show']);
Route::post('/api-alimentation/{id}', [APIAlimentationController::class, 'update']);
Route::delete('/api-alimentation/{id}', [APIAlimentationController::class, 'destroy']);

Route::get('/api-reproductions/{site_id}', [APIReproductionController::class, 'index']);
Route::post('/api-reproduction', [APIReproductionController::class, 'store']);
Route::get('/api-reproduction/{id}', [APIReproductionController::class, 'show']);
Route::post('/api-reproduction/{id}', [APIReproductionController::class, 'update']);
Route::delete('/api-reproduction/{id}', [APIReproductionController::class, 'destroy']);

Route::get('/api-relocations/{site_id}', [APIRelocationController::class, 'index']);
Route::post('/api-relocation', [APIRelocationController::class, 'store']);
Route::get('/api-relocation/{id}', [APIRelocationController::class, 'show']);
Route::post('/api-relocation/{id}', [APIRelocationController::class, 'update']);
Route::delete('/api-relocation/{id}', [APIRelocationController::class, 'destroy']);

Route::get('/api-observations/{site_id}', [APIObservationController::class, 'index']);
Route::post('/api-observation', [APIObservationController::class, 'store']);
Route::get('/api-observation/{id}', [APIObservationController::class, 'show']);
Route::post('/api-observation/{id}', [APIObservationController::class, 'update']);
Route::delete('/api-observation/{id}', [APIObservationController::class, 'destroy']);

Route::get('/species-list', function () {
    try {
        return response()->json(Specie::all('id', 'french_name'), 200);
    } catch (\Exception $e) {
        return response()->json($e);
    }
});

Route::get('/parents/{specie_id}', function () {
    try {
        return response()->json(
            Animal::where('specie_id', request('specie_id'))
                ->select('id', 'name')
                ->get(),
            200
        );
    } catch (\Exception $e) {
        return response()->json($e);
    }
});

Route::get('/pens-list/{site_id}', function () {
    try {
        return response()->json(
            Pen::where('site_id', request('site_id'))
                ->select('id', 'number')
                ->get(),
            200
        );
    } catch (\Exception $e) {
        return response()->json($e);
    }
});
