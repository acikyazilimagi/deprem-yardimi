<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DistrictApiRequest extends FormRequest
{
    public function authorize()
    {
        // TODO : X-AUTH-KEY ile kontrol edilmeli
        return true;
    }

    public function rules()
    {
        return [
            //
        ];
    }
}
