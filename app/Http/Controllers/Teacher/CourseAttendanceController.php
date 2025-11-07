<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAttendanceRequest;
use App\Http\Requests\UpdateAttendanceRequest;
use App\Models\Attendance;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseAttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Course $course)
    {
        $course->load('classDays.attendances.student');
        $classDays = $course->classDays;

        $percentageByStudent = $course->students->mapWithKeys(function ($student) use ($classDays) {
            $totalClasses = $classDays->count();
            $attendedClasses = $classDays->filter(function ($classDay) use ($student) {
                $attendance = $classDay->attendances->where('student_id', $student->id)->first();

                return $attendance && $attendance->present;
            })->count();

            $percentage = $totalClasses > 0 ? ($attendedClasses / $totalClasses) * 100 : 0;

            return [$student->id => $percentage];
        });

        $percentageByDay = $classDays->mapWithKeys(function ($classDay) use ($course) {
            $totalStudents = $course->students->count();
            $presentCount = $classDay->attendances->where('present', true)->count();

            $percentage = $totalStudents > 0 ? ($presentCount / $totalStudents) * 100 : 0;

            return [$classDay->id => $percentage];
        });

        return view('teacher.courses.attendances.index', [
            'course' => $course,
            'class_days' => $classDays,
            'percentage_by_student' => $percentageByStudent,
            'percentage_by_day' => $percentageByDay,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAttendanceRequest $request, Course $course)
    {
        $validated = $request->validated();

        // Check if attendances for the given date already exist
        if ($course->classDays()->whereDate('class_date', $validated['class_date'])->exists()) {
            return redirect()->back()
                ->withErrors(['class_date' => __('Ya existen asistencias para esta fecha.')])
                ->withInput();
        }

        $classDay = $course->classDays()->create([
            'class_date' => $validated['class_date'],
        ]);

        foreach ($validated['attendances'] as $attendanceData) {
            $attendance = $classDay->attendances()->make($attendanceData);
            $attendance->student_id = $attendanceData['student_id'];
            $attendance->save();
        }

        return redirect()->route('teacher.courses.attendances.index', $course)
            ->with('success', __('Asistencias guardadas correctamente.'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Attendance $attendance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Attendance $attendance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAttendanceRequest $request, Course $course, Attendance $attendance)
    {
        $attendance->update($request->validated());

        return redirect()->route('teacher.courses.attendances.index', $course)
            ->with('success', __('Asistencia actualizada correctamente.'));
    }

    /**
     * Store a single attendance record for an existent class day.
     */
    public function storeSingle(Request $request, Course $course)
    {
        $validated = $request->validate([
            'student_id' => ['required', 'integer', 'exists:students,id'],
            'class_date' => ['required', 'date'],
            'present' => ['required', 'boolean'],
            'status' => ['nullable', 'in:present,absent,excused'],
            'note' => ['nullable', 'string', 'max:255'],
        ]);

        $classDay = $course->classDays()->whereDate('class_date', $validated['class_date'])->firstOrFail();

        $attendance = $classDay->attendances()->make($validated);
        $attendance->student_id = $validated['student_id'];
        $attendance->save();

        return redirect()->route('teacher.courses.attendances.index', $course)
            ->with('success', __('Asistencia guardada correctamente.'));
    }
}
