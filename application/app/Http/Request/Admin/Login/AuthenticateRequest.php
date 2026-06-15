<?php

namespace Application\Http\Request\Admin\Login;

use Illuminate\Foundation\Http\FormRequest;

class AuthenticateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, string>
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email',
            'password' => 'required',
        ];
    }

    /**
     * @return string
     */
    public function email(): string
    {
        return $this->input('email');
    }

    /**
     * @return string
     */
    public function password(): string
    {
        return $this->input('password');
    }
}
