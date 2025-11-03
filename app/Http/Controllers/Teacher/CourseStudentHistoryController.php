<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Assessment;
use App\Models\Course;
use App\Models\Student;
use Illuminate\Http\Request;

class CourseStudentHistoryController extends Controller
{
    /**
     * Show all grades for a given student in a given assessment.
     */
    public function __invoke(Request $request, Course $course, Student $student, Assessment $assessment)
    {
        return view('teacher.courses.students.history', [
            'course' => $course,
            'student' => $student,
            'assessment' => $assessment,
            'grades' => $student->grades->where('assessment_id', $assessment->id),
        ]);
    }
}
