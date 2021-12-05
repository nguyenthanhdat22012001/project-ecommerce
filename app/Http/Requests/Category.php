<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class Category extends FormRequest
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
            'name'=>'required|max:255|unique:category',
            'slug'=>'unique:category',
            'img',
            'description',
            'hide',
        ];
    }
    public function messages()
    {
        return [
            'name.required'=>'Vui lòng nhập tên',
            'name.max'=>'Tên phải ít hơn 255 kí tự',
            'name.unique'=>'Tên category này đã tồn tại',
            'slug.unique'=>'Slug này đã tồn tại'
        ];
    }
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => $validator->errors()->first(),

        ]));
    }
}
