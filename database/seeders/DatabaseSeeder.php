<?php

namespace Database\Seeders;

use App\Models\Assessment;
use App\Models\Attendance;
use App\Models\ClassDay;
use App\Models\Course;
use App\Models\Grade;
use App\Models\Student;
use App\Models\StudentGroup;
use App\Models\Teacher;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

const COURSES_COUNT = 3;
const TEACHERS_COUNT = 2;
const STUDENTS_COUNT = 30;
const ASSESSMENTS_COUNT = 15;
const GRADES_COUNT = 15;
const CLASSDAYS_COUNT = 10;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Course::factory(COURSES_COUNT)->create();
        Teacher::factory(TEACHERS_COUNT)->create();
        Student::factory(STUDENTS_COUNT)->create();

        // generate example user emails
        Teacher::first()->user()->update(['email' => 'teacher@example.com']);
        Student::first()->user()->update(['email' => 'student@example.com']);

        $allCourses = Course::all();
        $allTeachers = Teacher::all();
        $allStudents = Student::all();
        $studentGroups = $allStudents->split($allCourses->count());

        foreach ($allCourses as $index => $course) {
            $teachersCount = rand(1, TEACHERS_COUNT);
            $selectedTeachers = $allTeachers->take(1)->merge($allTeachers->skip(1)->random($teachersCount - 1));
            $selectedStudents = $studentGroups[$index];

            $course->teachers()->attach($selectedTeachers);
            $course->students()->attach($selectedStudents);

            $this->command->info("Course '{$course->id}' assigned to {$selectedTeachers->count()} teachers and {$selectedStudents->count()} students.");

            // Create individual assessments for each course
            $assessmentsCount = rand(ASSESSMENTS_COUNT / 2, ASSESSMENTS_COUNT);
            $this->command->info("- Creating {$assessmentsCount} individual assessments for course '{$course->id}'...");
            $courseAssessments = Assessment::factory($assessmentsCount)
                ->for($course)
                ->individual()
                ->create()
                ->each(function ($assessment) use ($selectedStudents) {
                    // create some grades for each assessment
                    $gradesCount = rand(0, GRADES_COUNT);
                    $this->command->info("-- Creating {$gradesCount} grades for assessment '{$assessment->id}'...");

                    Grade::factory()
                        ->count($gradesCount)
                        ->for($assessment)
                        ->forStudent()
                        ->recycle($selectedStudents)
                        ->create();
                });

            // Create group assessments for each course
            $groupAssessmentsCount = rand(ASSESSMENTS_COUNT / 2, ASSESSMENTS_COUNT);
            $this->command->info("- Creating {$groupAssessmentsCount} group assessments for course '{$course->id}'...");
            $courseGroupAssessments = Assessment::factory($groupAssessmentsCount)
                ->for($course)
                ->group()
                ->create()
                ->each(function ($assessment) use ($selectedStudents) {
                    // create some student groups for each group assessment
                    $studentGroupsCount = rand(2, 5);
                    $this->command->info("-- Creating {$studentGroupsCount} student groups for group assessment '{$assessment->id}'...");
                    $studentsForStudentsGroups = $selectedStudents->shuffle()->split($studentGroupsCount);
                    $studentGroups = StudentGroup::factory()
                        ->count($studentGroupsCount)
                        ->for($assessment)
                        ->create()
                        ->each(function ($studentGroup, $index) use ($studentsForStudentsGroups) {
                            $studentGroup->students()->attach($studentsForStudentsGroups[$index]);
                        });

                    // create some grades for each group assessment
                    $gradesCount = rand(0, GRADES_COUNT);
                    $this->command->info("-- Creating {$gradesCount} grades for group assessment '{$assessment->id}'...");
                    Grade::factory()
                        ->count($gradesCount)
                        ->for($assessment)
                        ->forStudentGroup()
                        ->recycle($studentGroups)
                        ->create();
                });

            // Create some ClassDays for each Course
            $this->command->info("- Creating ClassDays for course '{$course->id}'");
            $courseClassDays = ClassDay::factory(rand(1, CLASSDAYS_COUNT))
                ->for($course)
                ->create()
                ->each(function ($classDay) use ($selectedStudents) {
                    $this->command->info("-- Begin creating attendances for ClassDay '{$classDay->id}'...");
                    // create Attendances for each ClassDay
                    foreach ($selectedStudents as $student) {
                        $this->command->info("--- Creating attendance for student '{$student->id}'...");
                        Attendance::factory()
                            ->for($classDay)
                            ->for($student)
                            ->create();
                    }
                });
        }
    }
}
