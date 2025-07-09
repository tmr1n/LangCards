<?php

namespace App\Http\Requests\Api\V1\TestRequests;

use Illuminate\Foundation\Http\FormRequest;

class EndTestRequest extends FormRequest
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
            'attemptId' => ['required', 'int'],
            'automatic'=>['required', 'boolean'],
            'answers' => ['required', 'array'],
            'answers.*.question_id' => ['required', 'int'],
            'answers.*.answer_id' => ['nullable', 'int'],
        ];
    }
    public function messages(): array
    {
        return [
            'attemptId.required' => 'Поле attemptId обязательно.',
            'attemptId.int' => 'Поле attemptId должно быть целым числом.',

            'automatic.required' => 'Поле automatic обязательно.',
            'automatic.boolean' => 'Поле automatic должно быть логическим значением (true или false).',

            'answers.required' => 'Поле answers обязательно.',
            'answers.array' => 'Поле answers должно быть массивом.',

            'answers.*.question_id.required' => 'Каждый ответ должен содержать поле question_id.',
            'answers.*.question_id.int' => 'Поле question_id в каждом ответе должно быть целым числом.',

            'answers.*.answer_id.int' => 'Поле answer_id в каждом ответе должно быть целым числом.',
        ];
    }
}
