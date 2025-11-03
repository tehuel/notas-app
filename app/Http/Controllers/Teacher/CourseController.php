<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses = auth()->user()->teacher->courses;

        return view('teacher.courses.index', [
            'courses' => $courses,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('teacher.courses.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'division' => 'required|string|max:255',
            'orientation' => 'required|string|max:255',
            'year' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        auth()->user()->teacher->courses()->create($validated);

        return redirect()
            ->route('teacher.courses.index')
            ->with('success', __('Curso creado correctamente.'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        $course->load([
            'assessments',
            'students',
            'teachers',
        ]);

        return view('teacher.courses.show', [
            'course' => $course,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {
        return view('teacher.courses.form', [
            'course' => $course,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Course $course)
    {
        $validated = $request->validate([
            'division' => 'required|string|max:255',
            'orientation' => 'required|string|max:255',
            'year' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $course->update($validated);

        return redirect()
            ->route('teacher.courses.show', [$course])
            ->with('success', __('Curso actualizado correctamente.'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        $course->delete();

        return redirect()
            ->route('teacher.courses.index')
            ->with('success', __('Curso eliminado correctamente.'));
    }
}
