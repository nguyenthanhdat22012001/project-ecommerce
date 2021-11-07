<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class PostsStore extends FormRequest
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
            'name' =>'required|max:255|unique:posts',
            'description' =>'required|max:255'
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Tên post không được để trống',
            'name.unique' => 'Tên post đã tồn tại',
            'description.required' => 'Mô tả post không được để trống',
        ];
    }
    public function failedValidation(Validator $validator)
    {
       throw new HttpResponseException(response()->json([
         'success'   => false,
         'message'   => 'Lỗi!',
         'data'      => $validator->errors()
       ]));
    }
}
