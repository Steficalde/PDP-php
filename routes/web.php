<?php

use App\Http\Controllers\DocumentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SchoolClassController;
use App\Http\Controllers\StudentController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



/**
 *
 * /documents
 * /documents/[document]
 * /documents/[document]/edit
 *
 * /years/[year]/classes
 * /years/[year]/classes/[class]/students
 * /years/[year]/classes/[class]/students/[student]
 * /years/[year]/classes/[class]/students/[student]/document/[document]
 * /years/[year]/classes/[class]/students/[student]/document/[document]/edit
 *
 */
Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('years.classes', SchoolClassController::class);
    Route::resource('years.classes.students', StudentController::class);
    Route::resource('years.classes.students', StudentController::class);


});

Route::middleware(['auth', 'verified', 'responsible'])->group(function () {
    Route::resource('documents', DocumentController::class);
});








require __DIR__.'/auth.php';
