<?php

namespace App\Http\Requests\Api\V1\TestRequests;

use Illuminate\Foundation\Http\FormRequest;

class StartTestRequest extends FormRequest
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
        return [
            'testId' => ['required', 'int'],
        ];
    }
    public function messages(): array
    {
        return [
            'testId.required' => 'Поле testId обязательно для заполнения.',
            'testId.int' => 'Поле testId должно быть типа int (целое число).'
        ];
    }
}
