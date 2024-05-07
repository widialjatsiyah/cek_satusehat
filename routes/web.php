<?php

use App\Http\Controllers\ConditionController;
use App\Http\Controllers\EncounterController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FHIRController;
use App\Http\Controllers\PatientController;
use Satusehat\Integration\FHIR\Condition;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/token', [FHIRController::class, 'token'])->name('token');

Route::controller(EncounterController::class)->group(function () {
    Route::get('/encounter/{id}', 'show');
    Route::post('/encounter', 'store');
    Route::put('/encounter', 'update');
});

Route::controller(PatientController::class)->group(function () {
    Route::get('/patient/by_id/{id}', 'by_id');
    Route::get('/patient/by_nik/{id}', 'by_nik');
    Route::post('/patient', 'store');
});


Route::controller(ConditionController::class)->group(function () {
    Route::get('/condition/{id}', 'show');
    Route::post('/condition', 'store');
    Route::put('/condition', 'update');
});

// Route::get('/encounter', [FHIRController::class, 'encounter'])->name('encounter');
// Route::get('/condition', [FHIRController::class, 'condition'])->name('condition');
// Route::get('/organization', [FHIRController::class, 'organization'])->name('organization');

