<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateUserRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|email:rfc|unique:users',
            'status' => 'required',
            'role' => 'required',
            'avatar' => 'nullable',
            'password' => 'bail|required|confirmed',
            'password_confirmation' => 'required'
        ];

        if ($this->has('_method')) {
            $rules['password'] = 'nullable|confirmed';
            $rules['password_confirmation'] = 'required_with:password';
            $rules['email'] = ['bail', 'required', 'email:rfc', Rule::unique('users')->ignore(request()->input('id'))];
        }

        return $rules;
    }
}
