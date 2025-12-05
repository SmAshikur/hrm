<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEmployeeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $employeeId = $this->route('employee')->id ?? null;

        return [
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => ['required','email', Rule::unique('employees','email')->ignore($employeeId)],
            'department_id' => 'required|exists:departments,id',
            'skills' => 'nullable|array',
            'skills.*' => 'exists:skills,id'
        ];
    }
}
