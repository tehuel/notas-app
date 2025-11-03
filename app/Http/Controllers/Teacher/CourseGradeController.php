<?php

namespace App\Http\Controllers\Teacher;

use App\Enums\GradeTypeEnum;
use App\Http\Controllers\Controller;
use App\Models\Assessment;
use App\Models\Course;
use App\Models\Grade;
use App\Models\Student;
use App\Models\StudentGroup;
use Illuminate\Http\Request;

class CourseGradeController extends Controller
{
    public function index(Course $course)
    {
        $individualAssessments = $course->assessments()->individual()->get();

        return view('teacher.courses.grades.index', [
            'course' => $course,
            'individualAssessments' => $individualAssessments,
        ]);
    }

    // store a single new grade
    public function store(Course $course, Request $request)
    {
        // validate fields
        $request->validate([
            // only one student_id or student_group_id should be present
            'student_id' => 'required_without:student_group_id|exists:students,id',
            'student_group_id' => 'required_without:student_id|exists:student_groups,id',
            'assessment_id' => 'required|exists:assessments,id',
            'value' => 'required',
            'comment' => 'nullable|string',
        ]);

        // validate value according to assessment type, return custom error messages
        $type = Assessment::findOrFail($request->input('assessment_id'))->grade_type;
        if ($type === GradeTypeEnum::Numeric) {
            $request->validate([
                'value' => 'numeric|min:1|max:10',
            ]);
        } elseif ($type === GradeTypeEnum::PassFail) {
            $request->validate([
                'value' => 'in:pass,fail',
            ], [
                'value.in' => __('La nota debe ser "pass" o "fail".'),
            ]);
        } elseif ($type === GradeTypeEnum::Semaphore) {
            $request->validate([
                'value' => 'in:satisfactory,unsatisfactory,warning',
            ], [
                'value.in' => __('La nota debe ser "satisfactory", "unsatisfactory" o "warning".'),
            ]);
        }

        // get related gradable model
        if ($request->has('student_id')) {
            $gradable = Student::findOrFail($request->input('student_id'));
        } else {
            $gradable = StudentGroup::findOrFail($request->input('student_group_id'));
        }

        // create grade
        $grade = new Grade([
            'type' => $type,
            'value' => $request->input('value'),
            'comment' => $request->input('comment'),
        ]);
        $grade->assessment()->associate($request->input('assessment_id'));
        $grade->gradable()->associate($gradable);
        $grade->save();

        return redirect()->back()
            ->with('success', __('Nota guardada correctamente.'));
    }
}
