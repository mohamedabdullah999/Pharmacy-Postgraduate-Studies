<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePgStudentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->role === 'admin';
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'national_id' => ['required', 'string', 'size:14', 'unique:pg_students,national_id'],
            'student_code' => ['required', 'string', 'max:50', 'unique:pg_students,student_code'],
            'dob' => ['nullable', 'date'],
            'birth_governorate' => ['nullable', 'string', 'max:100'],
            'current_address' => ['nullable', 'string'],
            'mobile_number' => ['nullable', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:255'],
            'current_job' => ['nullable', 'string', 'max:255'],
            'academic_degree' => ['nullable', 'string', 'max:255'],
            'degree_year' => ['nullable', 'integer', 'digits:4'],
            'degree_institution' => ['nullable', 'string', 'max:255'],
            'general_grade' => ['nullable', 'string', 'max:50'],
            'specialization_grade' => ['nullable', 'string', 'max:50'],
            'program_type' => ['required', 'in:pre_master,master,phd'],
            'enrollment_start_date' => ['nullable', 'date'],
            'supervisors' => ['nullable', 'array'],
            'supervisors.*' => ['exists:pg_supervisors,id'],
        ];
    }
}