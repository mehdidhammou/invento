<?php

use App\Models\Order;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use GuzzleHttp\RedirectMiddleware;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('filament.auth.login');
});

// Route::get('/dashboard', function () {
//     return redirect('/admin');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('export/')->group(function (){
        Route::get('order/{id}', [Controller::class, 'showOrder'])->name('export.order');
        Route::get('sale/{id}', [Controller::class , 'showSale'])->name('export.sale');
        Route::get('invoice/{id}', [Controller::class, 'showInvoice'])->name('export.invoice');
        Route::get('bl/{id}', [Controller::class, 'showBl'])->name('export.bl');

    });
});

Route::get('query', [Controller::class, 'query'])->name('query');


require __DIR__.'/auth.php';

