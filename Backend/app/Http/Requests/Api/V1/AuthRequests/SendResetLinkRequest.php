<?php

namespace App\Http\Requests\Api\V1\AuthRequests;

use Illuminate\Foundation\Http\FormRequest;

class SendResetLinkRequest extends FormRequest
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
            'email' => ['required', 'string', 'email', 'max:255', 'exists:users,email']
        ];
    }
    public function messages(): array
    {
        return [
            'email.required' => 'Поле Email обязательно для заполнения.',
            'email.string' => 'Email должен быть строкой.',
            'email.email' => 'Введите корректный Email.',
            'email.max' => 'Email не должен превышать 255 символов.',
            'email.exists' => 'Пользователь с заданным Email - адресом не найден.'
        ];
    }

}
