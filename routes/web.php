<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Student\DashboardController as StudentDashboardController;
use App\Http\Controllers\Teacher\CourseAssessmentController;
use App\Http\Controllers\Teacher\CourseAssessmentGroupController;
use App\Http\Controllers\Teacher\CourseAttendanceController;
use App\Http\Controllers\Teacher\CourseController as TeacherCourseController;
use App\Http\Controllers\Teacher\CourseGradeController;
use App\Http\Controllers\Teacher\CourseStudentController;
use App\Http\Controllers\Teacher\CourseStudentHistoryController;
use App\Http\Controllers\Teacher\CourseTeacherController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('index');

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        // TODO: move this to a middleware
        if (! auth()->user()->isTeacher() && ! auth()->user()->isStudent()) {
            return redirect()->route('index')->with('error', __('No tienes permiso para acceder al panel de control.'));
        }

        return redirect()->route(auth()->user()->isTeacher() ? 'teacher.dashboard' : 'student.dashboard');
    })->name('dashboard');

    // Teacher Routes
    Route::prefix('teacher')->as('teacher.')->group(function () {
        Route::get('/dashboard', function () {
            return redirect()->route('teacher.courses.index');
        })->name('dashboard');

        Route::resource('courses', TeacherCourseController::class);

        // Nested Teacher/Course Routes
        Route::prefix('courses/{course}/')->as('courses.')->group(function () {
            Route::resource('teachers', CourseTeacherController::class);
            Route::resource('grades', CourseGradeController::class);

            Route::post('assessments/sort/', [CourseAssessmentController::class, 'sort'])->name('assessments.sort');
            Route::resource('assessments', CourseAssessmentController::class);
            Route::resource('assessments.groups', CourseAssessmentGroupController::class);

            Route::get('students/{student}/history/{assessment}', CourseStudentHistoryController::class)->name('students.history');
            Route::get('students/associate/', [CourseStudentController::class, 'associate'])->name('students.associate');
            Route::post('students/associate/', [CourseStudentController::class, 'storeAssociation'])->name('students.storeAssociation');
            Route::post('students/sort/', [CourseStudentController::class, 'sort'])->name('students.sort');
            Route::resource('students', CourseStudentController::class);

            Route::post('attendances/storeSingle', [CourseAttendanceController::class, 'storeSingle'])->name('attendances.storeSingle');
            Route::resource('attendances', CourseAttendanceController::class);
        });
    });

    // Student Routes
    Route::prefix('student')->as('student.')->group(function () {
        Route::get('/dashboard', StudentDashboardController::class)->name('dashboard');
    });
});

require __DIR__.'/auth.php';
