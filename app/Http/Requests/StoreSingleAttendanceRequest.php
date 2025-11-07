<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreSingleAttendanceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $course = $this->route('course');

        return [
            'student_id' => [
                'required',
                'integer',
                'exists:students,id',
                Rule::exists('course_student', 'student_id')
                    ->where('course_id', $course->id),
            ],
            'class_date' => ['required', 'date'],
            'present' => ['required', 'boolean'],
            'status' => ['nullable', 'in:present,absent,excused'],
            'note' => ['nullable', 'string', 'max:255'],
        ];
    }
}
