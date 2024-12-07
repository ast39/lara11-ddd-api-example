<?php

namespace App\Modules\Post\Application\Requests;

use App\Modules\Post\Application\Enums\PostStatusEnum;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class PostCreateRequest extends FormRequest
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

            'title' => ['required', 'string', 'min:1'],
            'content' => ['required', 'string', 'min:1'],
            'status' => ['nullable', 'string', new Enum(PostStatusEnum::class)],
        ];
    }
}
