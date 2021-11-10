<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class TopicsStore extends FormRequest
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
            'name' =>'required|max:255|unique:topics',
            'slug' =>'required|max:255|unique:topics',
            'description' =>'required|max:255'
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Tên topic không được để trống',
            'name.unique' => 'Tên topic đã tồn tại',
            'slug.required' => 'Slug topic không được để trống',
            'slug.unique' => 'Slug topic đã tồn tại',
            'description.required' => 'Mô tả topic không được để trống',
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
