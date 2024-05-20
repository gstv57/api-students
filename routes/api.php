<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\V1\ClassRoomController;
use App\Http\Controllers\API\V1\{StudentsController, TeachersController};

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->group(function () {
    // section students
    Route::get('students', [StudentsController::class, 'index'])->name('students.index');
    Route::post('students', [StudentsController::class, 'store'])->name('students.store');
    Route::post('students/{id}', [StudentsController::class, 'show'])->name('students.show');
    Route::get('students/{id}/edit', [StudentsController::class, 'edit'])->name('students.edit');
    Route::put('students/{id}/edit', [StudentsController::class, 'update'])->name('students.update');
    Route::delete('students/{id}/delete', [StudentsController::class, 'destroy'])->name('students.destroy');

    // section teachers
    Route::get('teachers', [TeachersController::class, 'index'])->name('teachers.index');
    Route::post('teachers', [TeachersController::class, 'store'])->name('teachers.store');
    Route::post('teachers/{id}', [TeachersController::class, 'show'])->name('teachers.show');
    Route::get('teachers/{id}/edit', [TeachersController::class, 'edit'])->name('teachers.edit');
    Route::put('teachers/{id}/edit', [TeachersController::class, 'update'])->name('teachers.update');
    Route::delete('teachers/{id}/delete', [TeachersController::class, 'destroy'])->name('teachers.destroy');

    // section class room
    Route::get('class-rooms', [ClassRoomController::class, 'index'])->name('class-rooms.index');
    Route::post('class-rooms', [ClassRoomController::class, 'store'])->name('class-rooms.store');
    Route::post('class-rooms/{id}', [ClassRoomController::class, 'show'])->name('class-rooms.show');
    Route::get('class-rooms/{id}/edit', [ClassRoomController::class, 'edit'])->name('class-rooms.edit');
    Route::put('class-rooms/{id}/edit', [ClassRoomController::class, 'update'])->name('class-rooms.update');
    Route::delete('class-rooms/{id}/delete', [ClassRoomController::class, 'destroy'])->name('class-rooms.destroy');
    // route for return enums class rooms
    Route::get('class-rooms/enums', [ClassRoomController::class, 'fetchEnum'])->name('class-rooms.enums');
});
