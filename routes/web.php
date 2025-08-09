<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ResumeController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


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

Route::get('/',  function(){
    return Inertia::render('Welcome');
});


Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'saveUser']);
Route::get('/login', [AuthController::class, 'create'])->name('login');
Route::post('/login', [AuthController::class, 'store']);

Route::middleware(['auth'])->group(function () {

     Route::post('/logout', [AuthController::class, 'destroy']);
    Route::get('/profile', [PageController::class, 'index'])->name('profile');

    Route::get('/resume', [ResumeController::class, 'create']);
    Route::post('/resume', [ResumeController::class, 'store']);
    Route::get('/resume/{id}/edit', [ResumeController::class, 'edit'])->name('edit');
    Route::put('/resume/{id}/edit', [ResumeController::class, 'update'])->name('update');
    Route::delete('/resume/{id}/delete', [ResumeController::class, 'destroy'])->name('destroy');

    Route::get('/preview/{id}', [ResumeController::class, 'preview'])->name('preview');
    // Resume download routes
    Route::post('/user', [ResumeController::class, 'userProfile']);
    Route::delete('/user/delete', [ResumeController::class, 'userProfileDelete']);
});



Route::middleware(['auth'])->group(function () {
    Route::get('/resume/{id}/download', [ResumeController::class, 'download'])->name('resume.download')->middleware('check.payment');
    Route::get('/resume/{id}/view', [ResumeController::class, 'view'])->name('resume.view')->middleware('check.payment');

    Route::get('/stripe', [PaymentController::class, 'index'])->name('stripe.index');
    Route::post('/stripe', [PaymentController::class, 'store'])->name('stripe.payment');
    });

