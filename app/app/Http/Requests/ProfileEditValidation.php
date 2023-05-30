<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileEditValidation extends FormRequest
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
            'profile_bgp' => 'nullable|image|mimes:jpeg,png|max:2048',
            'icon' => 'nullable|image|mimes:jpeg,png|max:2048',
            'name' => 'required|min:1|max:20',
            'bio' => 'nullable|min:1|max:200',
        ];
    }
}
