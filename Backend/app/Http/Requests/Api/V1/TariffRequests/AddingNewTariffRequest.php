<?php

namespace App\Http\Requests\Api\V1\TariffRequests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AddingNewTariffRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'days' => ['required', 'integer', 'min:1', Rule::unique('tariffs', 'days')],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Поле "Название" обязательно для заполнения.',
            'name.string' => 'Поле "Название" должно быть строкой.',
            'name.max' => 'Поле "Название" не должно превышать 255 символов.',

            'days.required' => 'Поле "Количество дней" обязательно для заполнения.',
            'days.integer' => 'Поле "Количество дней" должно быть целым числом.',
            'days.min' => 'Поле "Количество дней" должно быть больше нуля.',
            'days.unique' => 'Тариф с таким количеством дней уже существует.'
        ];
    }
}
