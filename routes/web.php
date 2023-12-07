<?php

use App\Http\Controllers\SponsorsController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\PageController as AdminPageController;
use App\Http\Controllers\Guest\PageController as GuestPageController;
use App\Http\Controllers\Admin\ApartmentsController;


use App\Http\Controllers\Admin\MessageController;


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

Route::get('/', [GuestPageController::class, 'index'])->name('guest.home');

Route::get('/guest/show/{apartment}', [GuestPageController::class, 'show'])->name('guest.apartments.show');


Route::middleware(['auth', 'verified'])
  ->prefix('admin')
  ->name('admin.')
  ->group(function () {

    Route::get('/', [AdminPageController::class, 'index'])->name('home');

    // gestione rotte appartamenti utente registrato
    Route::resource('apartments', ApartmentsController::class);

    // utenti sponsorizzati
    Route::resource('/sponsors', SponsorsController::class);

    // per i messaggi
    Route::resource('/messages', MessageController::class);

    // statistiche appartamenti
    Route::resource('/statistics', ApartmentsController::class);
  });


// gestione sponsorizzazioni

Route::get('/sponsor/{apartment_id}', [SponsorsController::class, 'selectSponsor'])->name('sponsorSelect');

//  crezione sponsorizzazioni 

Route::post('/sponsor/sponsorship', [SponsorsController::class, 'sponsorship'])->name('sponsorship');

//messaggi utente
Route::post('/invia-messaggio', [MessageController::class, 'inviaMessaggio'])->name('invia.messaggio');

require __DIR__ . '/auth.php';

// vista statistiche appartamento
Route::get('/statistics/{apartment_id}', [ApartmentsController::class, 'showStatistics'])->name('show.statistics');

// lista messaggi in dashboard admin