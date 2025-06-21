<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class RegistrationRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => 'required|string|confirmed|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/',
        ];
    }
    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Поле имени обязательно для заполнения',
            'email.required' => 'Поле email обязательно для заполнения',
            'email.unique' => 'Пользователь с таким email уже существует',
            'password.required' => 'Поле пароля обязательно для заполнения',
            'password.confirmed' => 'Пароли не совпадают',
            'password.min'=>'Пароль должен содержать минимум 8 символов',
            'password.regex' => 'Пароль должен содержать минимум 1 заглавную букву, 1 строчную букву, 1 цифру и 1 специальный символ',
        ];
    }
}
