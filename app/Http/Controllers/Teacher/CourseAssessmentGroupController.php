<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Assessment;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CourseAssessmentGroupController extends Controller
{
    public function create(Course $course, Assessment $assessment): \Illuminate\View\View
    {
        // assignations is an object where keys are student IDs and values are group IDs
        $assignations = $course->students->mapWithKeys(function ($student) use ($assessment) {
            $group = $assessment->studentGroups()->whereHas('students', function ($query) use ($student) {
                $query->where('students.id', $student->id);
            })->first();

            return [$student->id => $group ? $group->id : null];
        });

        return view('teacher.courses.assessments.groups.form', [
            'course' => $course,
            'assessment' => $assessment,
            'assignations' => $assignations,
        ]);
    }

    public function store(Request $request, Course $course, Assessment $assessment)
    {
        // Validate and process the request data
        $validated = $request->validate([
            'groups' => 'required|array',
            'students' => 'required|array',
        ]);

        // detach all students from all groups
        $assessment->studentGroups()->each(function ($group) {
            $group->students()->detach();
        });

        // delete removed groups
        $existingGroupIds = $assessment->studentGroups()->pluck('id');
        $submittedGroupIds = collect($validated['groups'])->pluck('id');
        $groupsToDelete = $existingGroupIds->diff($submittedGroupIds);
        $groupsToDelete->each(function ($groupId) use ($assessment) {
            $group = $assessment->studentGroups()->find($groupId);
            $group->delete();
        });

        // update existing groups
        $existingGroups = collect($validated['groups'])
            ->filter(fn ($group) => ! Str::startsWith($group['id'], 'new-'))
            ->each(function ($group) use ($assessment) {
                // update the existing group
                $existingGroup = $assessment->studentGroups()->find($group['id']);
                $existingGroup->update([
                    'title' => $group['title'],
                ]);
            });

        // create new groups and map temporary IDs to new IDs
        $newGroups = collect($validated['groups'])
            ->filter(fn ($group) => Str::startsWith($group['id'], 'new-'))
            ->mapWithKeys(function ($group) use ($assessment) {
                // create the new group, and map the temporary ID to the new ID
                $newGroup = $assessment->studentGroups()->create([
                    'title' => $group['title'],
                ]);

                return [$group['id'] => $newGroup->id];
            });

        // assign all students to current groups
        collect($validated['students'])
            ->each(function ($groupId, $studentId) use ($assessment, $newGroups) {
                // if the group ID is a temporary ID, replace it with the new ID
                if (Str::startsWith($groupId, 'new-')) {
                    $groupId = $newGroups->get($groupId);
                }

                // assign the student to the group
                $assessment->studentGroups()->find($groupId)->students()->attach($studentId);
            });

        return redirect()->route('teacher.courses.assessments.show', [$course, $assessment]);
    }
}
