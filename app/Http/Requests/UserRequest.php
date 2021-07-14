<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class UserRequest extends FormRequest
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
            'name'      => 'required|min:4',
            'email'     => 'required|email|unique:users',
            'password'  => 'required|min:6',
        ];
    }

    public function messages()
    {
    return [
        'required'  =>':attribute Không được để trống',
        'unique'    =>':attribute đã được đăng kí',
        'min'       =>':attribute Không nhỏ hơn :min ký tự'
        ];
    }
    
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'errors' => [
                'status'    => false,
                'code'      => Response::HTTP_UNPROCESSABLE_ENTITY,
                'messages'  => $validator->errors()
            ]
        ],Response::HTTP_UNPROCESSABLE_ENTITY));
    }
    
}
