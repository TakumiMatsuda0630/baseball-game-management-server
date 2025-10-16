<?php

declare(strict_types=1);
namespace Application\Http\Request\Admin\Stadium;
use Illuminate\Foundation\Http\FormRequest;

class UpdateStadiumRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, string>
     */
    public function rules(): array
    {
        return [
            'stadium_name' => 'required|string|max:100',
        ];
    }

    /**
     * @return string
     */
    public function stadiumName(): string
    {
        return $this->input('stadium_name');
    }
}