<?php

use App\Models\Site;
use Inertia\Inertia;
use App\Models\Animal;
use App\Models\Specie;
use App\Models\Reproduction;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OngController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GenusController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReignController;
use App\Http\Controllers\AnimalController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\FamilyController;
use App\Http\Controllers\SpecieController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ObservationController;
use App\Http\Controllers\TypeHabitatController;
use App\Http\Controllers\ClassificationController;

Route::get('/', [LandingController::class, 'index'])->name('guest.index');
Route::get('/guest/sites', [LandingController::class, 'indexSite'])->name('guest.sites');
Route::get('/guest/sites/{id}', [LandingController::class, 'showSite'])->name('guest.sites.show');
Route::get('/guest/species', [LandingController::class, 'indexSpecies'])->name('guest.species');


Route::get('/dashboard', function () {
    $speciesCount = Specie::count();
    $animalsCount = Animal::count();
    $siteCount = Site::count();
    $newBornCount = Reproduction::whereRaw('ABS(TIMESTAMPDIFF(DAY, date, CURDATE())) < 1')->count();
    return Inertia::render('Dashboard', [
        'speciesCount' => $speciesCount,
        'animalsCount' => $animalsCount,
        'siteCount' => $siteCount,
        'newBornCount' => $newBornCount
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::resource('orders', OrderController::class);
    Route::resource('reigns', ReignController::class);
    Route::resource('genera', GenusController::class);
    Route::resource('branches', BranchController::class);
    Route::resource('families', FamilyController::class);
    Route::resource('classifications', ClassificationController::class);

    Route::resource('ongs', OngController::class);
    Route::resource('users', UserController::class);
    Route::resource('sites', SiteController::class);
    Route::resource('species', SpecieController::class);
    Route::resource('animals', AnimalController::class);
    Route::resource('observations', ObservationController::class);
    Route::resource('type-habitats', TypeHabitatController::class);


    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
