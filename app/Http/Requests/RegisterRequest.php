<?php

namespace App\Http\Requests;

use App\Exceptions\AppException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'email' => 'required|unique:users|email',
            'password' => 'required|min:4',
        ];
    }


    public function failedValidation(Validator $validator)
    {
        $result = [
            'success'   => false,
            'message'   => 'Validation errors',
            'data'      => $validator->errors()
        ];
        throw new HttpResponseException(response()->json($result));
    }


    public function messages()
    {
        return [
            'email.required' => 'Email is required!',
            'email.unique' => 'This email is already in use.',
            'email.email' => 'Invalid email address'
        ];
    }
}
