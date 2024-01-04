<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{

    protected function prepareForValidation(): void
    {
        $this->merge([
            "username" => strtolower($this->input("username"))
        ]);
    }

    protected function passedValidation()
    {
        $this->merge([
            "password" => bcrypt($this->input("password"))
        ]);
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "username" => ["required"],
            "password" => ["required", Password::min(6)->letters()->numbers()->symbols()]
        ];
    }
}
