<?php

namespace App\Http\Requests\Tasks;

use Illuminate\Foundation\Http\FormRequest;

class Create extends FormRequest
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
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'color' => ['required', 'string', 'max:7'],
            'start' => ['required', 'string'],
            'end' => ['nullable', 'string'],
            'joinable' => ['required', 'boolean'],
            'full_day' => ['required', 'boolean']
        ];
    }
}
