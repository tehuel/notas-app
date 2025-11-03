<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $student = $request->user()->student;
        $student->load(['attendances', 'courses.classDays']);

        return view('student.dashboard', [
            'student' => $student,
        ]);
    }
}
