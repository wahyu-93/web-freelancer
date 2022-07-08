<?php

namespace App\Http\Requests\Dashboard\Service;

use Illuminate\Foundation\Http\FormRequest;

class StoreServiceRequest extends FormRequest
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
        // bisa kaini
        // title => 'required|string|max:255
        // atau kaini
        // title => ['required', 'strng', 'max:255']
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:5000'],
            'delivery_time' => ['required', 'integer', 'max:100'],
            'revision_time' => ['required', 'integer', 'max:100'],
            'price' => ['required', 'string'],
            'note'  => ['nullable', 'string', 'max:5000']
        ];
    }
}
