<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class TopicsUpdate extends FormRequest
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
            'name' =>'required|max:255',
            'slug' =>'required|max:255',
            'description' =>'required|max:255'
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Tên topic không được để trống',
            'slug.required' => 'Slug topic không được để trống',
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
