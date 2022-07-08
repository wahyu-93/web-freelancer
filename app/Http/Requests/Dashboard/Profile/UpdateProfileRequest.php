<?php

namespace App\Http\Requests\Dashboard\Profile;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
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
            'photo' => ['nullable', 'file', 'max:1024'],
            'role'  => ['nullable', 'string', 'max:100'],
            'contact_number'    => ['required', 'max:12', 'regex:/^([0-9\s\-\+\(\)]*)$/'],
            'biografi'  => ['nullable', 'string', 'max:5000']
        ];
    }
}
