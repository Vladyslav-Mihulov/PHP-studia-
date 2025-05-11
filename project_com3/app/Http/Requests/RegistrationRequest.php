<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegistrationRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

   public function rules(): array {
        return [
        'login' => 'required',
        'email' => 'required',
        'fname' => 'required',
        'lname' => 'required',
        'password1' => 'required|min:6',
        'password2' => 'required|same:password1',
        ];
    }
    
    public function messages(): array {
        return [
        'login.required' => 'Login nie może być pusty.',
        'email.required' => 'E-mail nie może być pusty.',
        'fname.required' => 'Imię nie może być puste.',
        'lname.required' => 'Nazwisko nie może być puste.',
        'password1.required' => 'Hasło nie może być puste.',
        'password1.min' => 'Hasło musi mieć co najmniej 6 znaków.',
        'password2.required' => 'Powtórzone hasło nie może być puste.',
        'password2.same' => 'Hasła muszą być takie same.',
        ];
    }
}
