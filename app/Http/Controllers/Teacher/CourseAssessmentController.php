<?php

namespace App\Http\Controllers\Teacher;

use App\Enums\AssessmentTypeEnum;
use App\Enums\GradeTypeEnum;
use App\Http\Controllers\Controller;
use App\Models\Assessment;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;

class CourseAssessmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Course $course)
    {
        return view('teacher.courses.assessments.index', [
            'course' => $course,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Course $course)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => ['nullable', new Enum(AssessmentTypeEnum::class)],
            'grade_type' => ['required', new Enum(GradeTypeEnum::class)],
            'checks' => 'nullable|array',
        ]);

        $course->assessments()->create($validated);

        return redirect()
            ->route('teacher.courses.assessments.index', $course)
            ->with('success', __('Evaluación creada correctamente.'));
    }

    public function sort(Request $request, Course $course)
    {
        $validated = $request->validate([
            'order' => 'required|array',
            'order.*' => 'required|integer|exists:assessments,id',
        ]);

        $now = now();

        foreach ($validated['order'] as $index => $id) {
            $course->assessments()
                ->where('id', $id)
                ->update(['order' => $index]);
        }

        return response()->json(['status' => 'ok']);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Course $course)
    {
        return view('teacher.courses.assessments.form', [
            'course' => $course,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course, Assessment $assessment)
    {
        $assessment->load([
            'course.students.grades' => fn ($query) => $query->where('assessment_id', $assessment->id),
        ]);

        return view('teacher.courses.assessments.show', [
            'course' => $course,
            'assessment' => $assessment,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course, Assessment $assessment)
    {
        return view('teacher.courses.assessments.form', [
            'course' => $course,
            'assessment' => $assessment,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Course $course, Assessment $assessment)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => ['nullable', new Enum(AssessmentTypeEnum::class)],
            'grade_type' => ['required', new Enum(GradeTypeEnum::class)],
            'checks' => 'nullable|array',
        ]);

        $assessment->update($validated);

        return redirect()
            ->route('teacher.courses.assessments.index', $course)
            ->with('success', __('Evaluación actualizada correctamente.'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course, Assessment $assessment)
    {
        $assessment->delete();

        return redirect()
            ->route('teacher.courses.assessments.index', $course)
            ->with('success', __('Evaluación eliminada correctamente.'));
    }
}
