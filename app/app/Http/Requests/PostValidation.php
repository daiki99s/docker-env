<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostValidation extends FormRequest
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
            'description' => 'required|min:1|max:200',
        ];
    
        // Store メソッドの場合のみ image フィールドにバリデーションを適用する
        if ($this->isMethod('post')) {
            $rules['image'] = 'required|image|mimes:jpeg,png|max:2048';
        }
    
        return $rules;
    }


}
