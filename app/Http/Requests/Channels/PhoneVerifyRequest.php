<?php

namespace App\Http\Requests\Channels;

use Illuminate\Foundation\Http\FormRequest;

class PhoneVerifyRequest extends FormRequest
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
            'phoneVerify' => 'required|size:4|exists:users,phone_verification_code'
        ];
    }

    public function messages()
    {
        return [
            'exists' => 'Verification code is invalid.'
        ];
    }
}
