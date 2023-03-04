<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\ContactItemController;
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

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::resource('contact', ContactController::class)
        ->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);

    Route::resource('contact.items', ContactItemController::class)
        ->only(['create', 'store', 'edit', 'update', 'destroy']);
});


Route::get('/docs', function () {
    if (! file_exists(public_path('docs/index.html'))) {
        return redirect('/');
    }

    return redirect('docs/index.html');
});
