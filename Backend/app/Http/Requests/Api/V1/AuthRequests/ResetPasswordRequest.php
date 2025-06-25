<?php

namespace App\Http\Requests\Api\V1\AuthRequests;

use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
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
            'email' => ['required', 'string', 'email', 'max:255', 'exists:password_reset_tokens,email'],
            'password' => 'required|string|confirmed|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/',
            'token' => 'required|string'
        ];
    }
    public function messages(): array
    {
        return [
            'email.required' => 'Поле Email обязательно для заполнения.',
            'email.string' => 'Email должен быть строкой.',
            'email.email' => 'Введите корректный Email.',
            'email.max' => 'Email не должен превышать 255 символов.',
            'email.exists' => 'Запрос на изменение пароля для заданного email - адреса не был осуществлен.',
            'password.required' => 'Поле пароля обязательно для заполнения',
            'password.confirmed' => 'Пароли не совпадают',
            'password.min'=>'Пароль должен содержать минимум 8 символов',
            'password.regex' => 'Пароль должен содержать минимум 1 заглавную букву, 1 строчную букву, 1 цифру и 1 специальный символ',
            'token.required' => "Поле 'токен' является обязательным",
            'token.string' => "Поле 'токен' должен быть строкой"
        ];
    }
}
