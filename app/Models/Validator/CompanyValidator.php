<?php

namespace App\Models\Validator;

use App\Models\Company;
use Illuminate\Validation\Rule;

class CompanyValidator
{
    public function validate(Company $company, array $attributes): array
    {
        return validator($attributes,
            [
                'name' => [Rule::when($company->exists, 'sometimes'), 'required', 'string', 'unique:companies', 'max:200'],
                'email' => [Rule::when($company->exists, 'sometimes'), 'nullable', 'string', 'unique:companies', 'max:150'],
                'logo' => [Rule::when($company->exists, 'sometimes'), 'nullable', 'image', 'dimensions:min_width=100,min_height=100', 'mimes:jpg,bmp,png'],
                'website' => [Rule::when($company->exists, 'sometimes'), 'nullable', 'string', 'unique:companies'],
            ]
        )->validate();
    }
}
