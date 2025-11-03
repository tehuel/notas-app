<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;

class CourseStudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Course $course)
    {
        return view('teacher.courses.students.index', [
            'course' => $course,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Course $course)
    {
        return view('teacher.courses.students.form', [
            'course' => $course,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Course $course)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'github_username' => 'nullable|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
        ]);

        $user = User::create([
            'email' => $validated['email'],
            'password' => bcrypt('password'), // Default password, should be changed later
        ]);

        $student = $user->student()->create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'github_username' => $validated['github_username'] ?? null,
        ]);

        $course->students()->attach($student);

        return redirect()
            ->route('teacher.courses.students.index', $course)
            ->with('success', __('Alumno creado correctamente.'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course, Student $student)
    {
        $course->load(['classDays', 'assessments']);
        $student->load(['attendances']);

        return view('teacher.courses.students.show', [
            'course' => $course,
            'student' => $student,
            'attendancesCount' => $student->attendances()
                ->present()
                ->inClassDays($course->classDays->pluck('id')->toArray())
                ->count(),
            'classDaysCount' => $course->classDays->count(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course, Student $student)
    {
        return view('teacher.courses.students.form', [
            'course' => $course,
            'student' => $student,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Course $course, Student $student)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'github_username' => 'nullable|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$student->user->id,
        ]);

        $student->user->update([
            'email' => $validated['email'],
        ]);

        $student->update([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'github_username' => $validated['github_username'] ?? null,
        ]);

        return redirect()
            ->route('teacher.courses.students.index', $course)
            ->with('success', __('Alumno actualizado correctamente.'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course, Student $student)
    {
        $student->courses()->detach();
        $student->user()->delete();
        $student->delete();

        return redirect()
            ->route('teacher.courses.students.index', $course)
            ->with('success', __('Alumno eliminado correctamente.'));
    }

    /**
     * Show the form for associating existing students to the course.
     */
    public function associate(Course $course)
    {
        $allStudents = Student::whereDoesntHave('courses', function ($query) use ($course) {
            $query->where('course_id', $course->id);
        })->get();

        return view('teacher.courses.students.associate', [
            'course' => $course,
            'allStudents' => $allStudents,
        ]);
    }

    /**
     * Handle the association of existing students to the course.
     */
    public function storeAssociation(Request $request, Course $course)
    {
        $validated = $request->validate([
            'students' => 'required|array',
            'students.*' => 'exists:students,id',
        ]);

        $course->students()->attach($validated['students']);

        return redirect()
            ->route('teacher.courses.students.index', $course)
            ->with('success', __('Alumnos asociados correctamente.'));
    }

    /**
     * Handle sorting of students within the course.
     */
    public function sort(Request $request, Course $course)
    {
        $validated = $request->validate([
            'order' => 'required|array',
            'order.*' => 'required|integer|exists:students,id',
        ]);

        foreach ($validated['order'] as $index => $id) {
            $course->students()
                ->where('id', $id)
                ->updateExistingPivot($id, ['order' => $index]);
        }

        return response()->json(['status' => 'ok']);

    }
}
