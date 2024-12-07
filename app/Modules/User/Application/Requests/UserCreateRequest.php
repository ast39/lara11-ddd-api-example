<?php

namespace App\Modules\User\Application\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UserCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function prepareForValidation()
    {
        //
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [

            'first_name' => ['required', 'string', 'min:2'],
            'second_name' => ['nullable', 'string'],
            'surname' => ['nullable', 'string'],
            'position' => ['required', 'string', 'min:3'],
            'login' => ['required', 'string', 'min:6', 'max:32'],
            'password' => ['nullable', 'string', 'min:8', 'max:32'],
            'is_blocked' => ['nullable', 'boolean'],
        ];
    }
}
