<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OngController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ExcelController;
use App\Http\Controllers\GenusController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReignController;
use App\Http\Controllers\AnimalController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\FamilyController;
use App\Http\Controllers\SpecieController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RelocationController;
use App\Http\Controllers\ObservationController;
use App\Http\Controllers\TypeHabitatController;
use App\Http\Controllers\ClassificationController;

Route::get('/', [LandingController::class, 'index'])->name('guest.index');
Route::get('/guest/sites', [LandingController::class, 'indexSite'])->name('guest.sites');
Route::get('/guest/sites/{id}', [LandingController::class, 'showSite'])->name('guest.sites.show');
Route::get('/guest/species', [LandingController::class, 'indexSpecies'])->name('guest.species');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', HomeController::class)->name('dashboard');

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
    Route::resource('relocations', RelocationController::class);
    Route::resource('observations', ObservationController::class);
    Route::resource('type-habitats', TypeHabitatController::class);

    Route::post('import-orders', [ExcelController::class, 'importOrder'])->name('orders.import');
    Route::post('import-reigns', [ExcelController::class, 'importReign'])->name('reigns.import');
    Route::post('import-genera', [ExcelController::class, 'importGenus'])->name('genera.import');
    Route::post('import-families', [ExcelController::class, 'importFamily'])->name('families.import');
    Route::post('import-branches', [ExcelController::class, 'importBranch'])->name('branches.import');
    Route::post('import-classifications', [ExcelController::class, 'importClassification'])->name('classifications.import');


    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
