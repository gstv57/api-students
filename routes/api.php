<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\V1\StudentsController;
use App\Http\Controllers\API\V1\TeachersController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->group(function () {
    Route::get('students', [StudentsController::class, 'index'])->name('students.index');
    Route::post('students', [StudentsController::class, 'store'])->name('students.store');
    Route::post('students/{id}', [StudentsController::class, 'show'])->name('students.show');
    Route::get('students/{id}/edit', [StudentsController::class, 'edit'])->name('students.edit');
    Route::put('students/{id}/edit', [StudentsController::class, 'update'])->name('students.update');
    Route::delete('students/{id}/delete', [StudentsController::class, 'destroy'])->name('students.destroy');

    Route::get('teachers', [TeachersController::class, 'index'])->name('teachers.index');
    Route::post('teachers', [TeachersController::class, 'store'])->name('teachers.store');
    Route::post('teachers/{id}', [TeachersController::class, 'show'])->name('teachers.show');
    Route::get('teachers/{id}/edit', [TeachersController::class, 'edit'])->name('teachers.edit');
    Route::put('teachers/{id}/edit', [TeachersController::class, 'update'])->name('teachers.update');
    Route::delete('teachers/{id}/delete', [TeachersController::class, 'destroy'])->name('teachers.destroy');
});
