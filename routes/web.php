<?php

use App\Http\Controllers\AdminManagementController;
use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\PaymentTypeController;
use App\Http\Controllers\PaymentModeController;
use App\Http\Controllers\SchoolyearController;
use App\Http\Controllers\SemesterController;
use App\Http\Controllers\SerieController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TeacherManagementController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
Route::middleware(['auth:sanctum',config('jetstream.auth_session'),'verified',
])->group(function () {
    Route::get('/dashboard', function () { return view('dashboard');})->name('dashboard');
    Route::resource('classrooms', ClassroomController::class);
    Route::resource('series', SerieController::class);
    Route::resource('subjects', SubjectController::class);
    Route::resource('semesters', SemesterController::class);
    Route::resource('school-years', SchoolyearController::class);
    Route::resource('payement-types', PaymentTypeController::class);
    Route::resource('payement-modes', PaymentModeController::class);
    Route::get('/admin/create', [AdminManagementController::class, 'create'])->name('admin.create');
    Route::post('/admin', [AdminManagementController::class, 'store'])->name('admin.store');
    Route::get('/teacher/create', [TeacherManagementController::class, 'create'])->name('teacher.create');
    Route::post('/teacher', [TeacherManagementController::class, 'store'])->name('teacher.store');
});

