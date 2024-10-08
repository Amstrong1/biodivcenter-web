<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OngController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ExcelController;
use App\Http\Controllers\AnimalController;
use App\Http\Controllers\SpecieController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\RelocationController;
use App\Http\Controllers\ObservationController;
use App\Http\Controllers\TypeHabitatController;
use App\Http\Controllers\AlimentationController;
use App\Http\Controllers\ReproductionController;
use App\Http\Controllers\SanitaryStateController;

Route::get('/', [LandingController::class, 'index'])->name('guest.index');
Route::get('/guest/sites', [LandingController::class, 'indexSite'])->name('guest.sites');
Route::get('/guest/sites/{id}', [LandingController::class, 'showSite'])->name('guest.sites.show');
Route::get('/guest/species', [LandingController::class, 'indexSpecies'])->name('guest.species');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', HomeController::class)->name('dashboard');

    Route::resource('tags', TagController::class);
    Route::resource('ongs', OngController::class);
    Route::resource('users', UserController::class);
    Route::resource('sites', SiteController::class);
    Route::resource('species', SpecieController::class);
    Route::resource('animals', AnimalController::class);
    Route::resource('relocations', RelocationController::class);
    Route::resource('observations', ObservationController::class);
    Route::resource('type-habitats', TypeHabitatController::class);

    Route::get('feedbacks', [FeedbackController::class, 'index'])->name('feedbacks.index');
    Route::get('alimentations', [AlimentationController::class, 'index'])->name('alimentations.index');
    Route::get('reproductions', [ReproductionController::class, 'index'])->name('reproductions.index');
    Route::get('sanitary-states', [SanitaryStateController::class, 'index'])->name('sanitary-states.index');

    Route::post('import-species', [ExcelController::class, 'importSpecie'])->name('species.import');
    Route::post('import-type-habitats', [ExcelController::class, 'importHabitatType'])->name('type-habitats.import');
    Route::post('import-ongs', [ExcelController::class, 'importOng'])->name('ongs.import');


    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
