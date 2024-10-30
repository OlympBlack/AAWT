<?php

use App\Http\Controllers\AdminManagementController;
use App\Http\Controllers\AdminNoteTypeController;
use App\Http\Controllers\AdminPaymentSettingsController;
use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\ParentDashboardController;
use App\Http\Controllers\SchoolyearController;
use App\Http\Controllers\SemesterController;
use App\Http\Controllers\SerieController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\StudentRegistrationController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TeacherDashboardController;
use App\Http\Controllers\TeacherManagementController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Point d'entrée de l'application
Route::get('/', function (Request $request) {
    $rolesMapping = [
        'admin' => 'dashboard',
        'parent' => 'parent.dashboard',
        'teacher' => 'teacher.dashboard',
        'student' => 'student.dashboard',
    ];
    if ($user = $request->user()) {
        if (isset($rolesMapping[$user->role->wording])) {
            $redirectRoute = $rolesMapping[$user->role->wording];
            return redirect()->route($redirectRoute);
        }
    }
    return redirect()->route('login')->with('error', 'Accès non autorisé.');
});

// Routes communes à tous les utilisateurs authentifiés
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::patch('/notifications/{id}/mark-as-read', function ($id) {
        auth()->user()->notifications()->findOrFail($id)->markAsRead();
        return back();
    })->name('notifications.markAsRead');
    // Routes Etudiant
    Route::middleware('role:student')->group(function () {
        Route::get('/student/dashboard', function () {
            return view('student.dashboard');
        })->name('student.dashboard');
    });
    // Routes Admin
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/dashboard', function () { return view('dashboard'); })->name('dashboard');
        Route::resource('classrooms', ClassroomController::class);
        Route::resource('series', SerieController::class);
        Route::resource('subjects', SubjectController::class);
        Route::resource('semesters', SemesterController::class);
        Route::post('/semesters/{id}/toggle-active', [SemesterController::class, 'toggleActive'])->name('semesters.toggle-active');
        Route::resource('school-years', SchoolyearController::class);
        // Route::resource('note-types', AdminNoteTypeController::class);
        
        // Paramètres de paiement
        Route::get('/admin/payment-settings', [AdminPaymentSettingsController::class, 'index'])->name('admin.payment-settings');
        Route::post('/admin/payment-modes', [AdminPaymentSettingsController::class, 'storePaymentMode'])->name('admin.payment-modes.store');
        // Route::post('/admin/payment-types', [AdminPaymentSettingsController::class, 'storePaymentType'])->name('admin.payment-types.store');
        Route::delete('/admin/payment-modes/{paymentMode}', [AdminPaymentSettingsController::class, 'destroyPaymentMode'])->name('admin.payment-modes.destroy');
        // Route::delete('/admin/payment-types/{paymentType}', [AdminPaymentSettingsController::class, 'destroyPaymentType'])->name('admin.payment-types.destroy');
        
        // Gestion des utilisateurs
        Route::get('/admin/create', [AdminManagementController::class, 'create'])->name('admin.create');
        Route::post('/admin', [AdminManagementController::class, 'store'])->name('admin.store');
        Route::get('/teacher/create', [TeacherManagementController::class, 'create'])->name('teacher.create');
        Route::post('/teacher', [TeacherManagementController::class, 'store'])->name('teacher.store');
    });

    // Routes Enseignant
    Route::middleware('role:teacher')->group(function () {
        Route::get('/teacher/dashboard', [TeacherDashboardController::class, 'index'])->name('teacher.dashboard');
        Route::get('/teacher/classes', [TeacherDashboardController::class, 'classes'])->name('teacher.classes');
        Route::get('/teacher/class/{classroom}/students', [TeacherDashboardController::class, 'students'])->name('teacher.class.students');
        Route::get('/teacher/class/{classroom}/student/{student}/notes', [TeacherDashboardController::class, 'studentNotes'])->name('teacher.student.notes');
        Route::post('/teacher/note/store', [TeacherDashboardController::class, 'storeNote'])->name('teacher.store-note');
        Route::put('/teacher/note/{note}', [TeacherDashboardController::class, 'updateNote'])->name('teacher.update-note');
        Route::delete('/teacher/note/{note}', [TeacherDashboardController::class, 'deleteNote'])->name('teacher.delete-note');
    });

    // Routes Parent
    Route::middleware('role:parent')->group(function () {
        Route::get('/parent/dashboard', [ParentDashboardController::class, 'index'])->name('parent.dashboard');
        Route::get('/parent/register-student', [StudentRegistrationController::class, 'showRegistrationForm'])->name('parent.register-student');
        Route::post('/parent/register-student', [StudentRegistrationController::class, 'register'])->name('parent.register-student.submit');
        Route::get('/parent/registration-form/{registrationId}', [StudentRegistrationController::class, 'generateRegistrationForm'])->name('parent.registration-form');
        Route::get('/parent/payment/{registrationId}', [StudentRegistrationController::class, 'showPaymentForm'])->name('parent.payment-form');
        Route::post('/parent/payment/{registrationId}', [StudentRegistrationController::class, 'processPayment'])->name('parent.process-payment');
       
    Route::get('/parent/student-card/{registration}', [StudentRegistrationController::class, 'generateStudentCard'])
        ->name('parent.student-card');
    });

    Route::get('/registration-form/{registrationId}', [StudentRegistrationController::class, 'generateRegistrationForm'])->name('registration.form.download');
});
Route::get('/student/verify/{id}', [StudentController::class, 'verify'])
->name('student.verify');