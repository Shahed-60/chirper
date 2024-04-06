<?php

use App\Http\Controllers\ChirpController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


//De resource-methode is een term die wordt gebruikt om een set van objecten te becschrijven die je kunt aanmaken,
// lezen, bijwerken en verwijderen(dus eigenlijk de crud) ipv dat ik het helemaal zelf moet schrijven.
// chirps is de naam van de resource en ChirpController is de controller.
Route::resource('chirps', ChirpController::class)
    ->only(['index', 'store'])
    // de auth en verified middleware zorgen ervoor dat je alleen kan posten als je bent ingelogd en je email is geverifieerd.
    ->middleware(['auth', 'verified']);




require __DIR__ . '/auth.php';
