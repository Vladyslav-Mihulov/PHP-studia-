<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
  
    public function authorize(): bool {
        return true;
    }

    public function rules(): array {
        return [
            'login' => 'required',  // Проверка логина в базе данных
            'password' => 'required'
        ];
    }
    
    public function messages(){
        return [
            'login.required' => 'Login nie może być pusty',
            'password.required' => 'Hasło nie może być puste'
        ];
    }
}
