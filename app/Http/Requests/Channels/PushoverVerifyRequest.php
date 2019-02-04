<?php

namespace App\Http\Requests\Channels;

use Illuminate\Foundation\Http\FormRequest;

class PushoverVerifyRequest extends FormRequest
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
            'pushoverVerify' => 'required|size:4|exists:users,pushover_verification_code'
        ];
    }

    public function messages()
    {
        return [
            'exists:users,pushover_verification_code' => 'Verification number is incorrect'
        ];
    }
}
