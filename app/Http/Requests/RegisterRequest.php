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
    protected $password;
    protected $password2;

    
    public function __construct(FormRequest $request){
        $this->password = $request->password;
        $this->password2 = $request->password2;
    }


    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'email' => 'required|unique:users|email',
            'password' => 'required|min:4',
            'password2' => 'required|same:password',
        ];
    }


    public function failedValidation(Validator $validator)
    {
        $result = [
            'success'   => false,
            'message'   => 'Validation errors',
            'errors'      => $validator->errors()
        ];
        throw new HttpResponseException(response()->json($result));
    }


    public function messages()
    {
        return [
            'email.required' => 'Email is required!',
            'email.unique' => 'This email is already in use.',
            'email.email' => 'Invalid email address.',
            'password.required' => 'Password is required!',
            'password.min' => 'The password field must be at least 4 characters long.',
            'password2.required' => 'Password confirmation is required!',
            'password2.same' => 'Passwords didn\'t match!',
        ];
    }
}
