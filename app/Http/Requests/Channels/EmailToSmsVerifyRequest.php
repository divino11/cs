<?php

namespace App\Http\Requests\Channels;

use Illuminate\Foundation\Http\FormRequest;

class EmailToSmsVerifyRequest extends FormRequest
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
            'emailToSmsVerify' => 'required|size:4|exists:users,email_to_sms_verification_code'
        ];
    }

    public function messages()
    {
        return [
            'exists:users,email_to_sms_verification_code' => 'Verification number is incorrect'
        ];
    }
}
