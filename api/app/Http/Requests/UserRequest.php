<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        return [
            'name' => 'required|max:255',
            'email' => 'email|required|unique:users,email|max:255',
            'password' => 'required|min:6|max:255',
            'password_confirmation' => 'same:password'
        ];
    }

    public function getUserDataForRegistration(): array
    {
        $userData = [];
        foreach (['name', 'email', 'password'] as $inputField) {
            $userData[$inputField] = $this->$inputField;
        }

        return $userData;
    }
}
