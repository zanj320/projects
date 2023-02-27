<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['required', 'min:3', 'max:50', 'regex:/^[a-zA-ZšđčćžŠĐČĆŽ]+$/'],
            'surname' => ['required', 'min:3', 'max:50', 'regex:/^[a-zA-ZšđčćžŠĐČĆŽ]+$/'],
            'email' => ['email:rfc,dns', 'unique:users'],
            'password' => ['min:6', 'max:255', 'required_with:confirm_password', 'same:confirm_password', 'regex:/[a-z]/', 'regex:/[A-Z]/','regex:/[0-9]/','regex:/[@$!%*#?&_.-]/'],
            'confirm_password' => ['min:6', 'same:password']
        ];
    }

    public function messages() {
        return [
            'name.reqired' => 'Name is required.',
            'name.min' => 'Name should be at least 3 length.',
            'name.max' => 'Name should be at most 50 length.',
            'name.regex' => 'Name can only contain letters.',
            
            'surname.min' => 'Surname should be at least 3 length.',
            'surname.max' => 'Surname should be at most 50 length.',
            'surname.regex' => 'Surname can only contain letters.',

            'email.email' => 'Email should be in correct format.',
            'email.unique' => 'Email already in use.',

            'password.min' => 'Password should be at least 6 length.',
            'password.max' => 'Password should be at most 255 length.',
            'password.required_with' => 'Password should be at least 6 length.',
            'password.same' => 'Passwords are not matching.',
            'password.regex' => 'Password must contain at least 1 upper, 1 lower, 1 number and 1 special character (@$!%*#?&_.-)'
        ];
    }
}
