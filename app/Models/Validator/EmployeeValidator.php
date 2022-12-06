<?php

namespace App\Models\Validator;

use App\Models\Employee;
use Illuminate\Validation\Rule;

class EmployeeValidator
{
    public function validate(Employee $employee, array $attributes): array
    {
        return validator($attributes,
            [
                'firstname' => [Rule::when($employee->exists, 'sometimes'), 'required', 'string', 'max:50'],
                'lastname' => [Rule::when($employee->exists, 'sometimes'), 'required', 'string', 'max:50'],
                'company_id' => [Rule::exists('companies', 'id')],
                'email' => [Rule::when($employee->exists, 'sometimes'), 'nullable', 'string', 'unique:employees', 'max:150'],
                'phone' => [Rule::when($employee->exists, 'sometimes'), 'nullable', 'string', 'unique:employees', 'max:15'],
            ]
        )->validate();
    }
}
