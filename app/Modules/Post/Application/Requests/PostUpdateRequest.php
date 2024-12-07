<?php

namespace App\Modules\Post\Application\Requests;

use App\Modules\Post\Application\Enums\PostStatusEnum;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class PostUpdateRequest extends FormRequest
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

            'title' => ['nullable', 'string', 'min:1'],
            'content' => ['nullable', 'string', 'min:1'],
            'author_id' => ['nullable', 'integer', 'exists:users,id'],
            'status' => ['nullable', 'string', new Enum(PostStatusEnum::class)],
        ];
    }
}
