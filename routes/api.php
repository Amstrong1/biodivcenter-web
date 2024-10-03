<?php

use App\Models\Animal;
use App\Models\Specie;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\FeedbackController;
use App\Http\Controllers\API\IndividuController;
use App\Http\Controllers\API\ObservationController;
use App\Http\Controllers\API\AlimentationController;
use App\Http\Controllers\API\ReproductionController;
use App\Http\Controllers\API\SanitaryStateController;

Route::get('/user/{id}', [UserController::class, 'show']);

Route::post('/user/{id}', [UserController::class, 'update']);

Route::post('/signin', [AuthController::class, 'signin']);

Route::post('/feedback', [FeedbackController::class, 'store']);

Route::get('/individus/{site_id}', [IndividuController::class, 'index']);
Route::post('/individu', [IndividuController::class, 'store']);
Route::delete('/individu/{id}', [IndividuController::class, 'destroy']);

Route::get('/api-sanitary-states/{site_id}', [SanitaryStateController::class, 'index']);
Route::post('/api-sanitary-state', [SanitaryStateController::class, 'store']);
Route::delete('/api-sanitary-state/{id}', [SanitaryStateController::class, 'destroy']);

Route::get('/api-alimentations/{site_id}', [AlimentationController::class, 'index']);
Route::post('/api-alimentation', [AlimentationController::class, 'store']);
Route::get('/api-alimentation/{id}', [AlimentationController::class, 'show']);
Route::delete('/api-alimentation/{id}', [AlimentationController::class, 'destroy']);

Route::get('/api-reproductions/{site_id}', [ReproductionController::class, 'index']);
Route::post('/api-reproduction', [ReproductionController::class, 'store']);
Route::get('/api-reproduction/{id}', [ReproductionController::class, 'show']);
Route::delete('/api-reproduction/{id}', [ReproductionController::class, 'destroy']);

Route::get('/api-observations/{site_id}', [ObservationController::class, 'index']);
Route::post('/api-observation', [ObservationController::class, 'store']);
Route::get('/api-observation/{id}', [ObservationController::class, 'show']);
Route::delete('/api-observation/{id}', [ObservationController::class, 'destroy']);

Route::get('/species-list', function () {
    try {
        return response()->json(Specie::select('id', 'french_name')->get(), 200);
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
