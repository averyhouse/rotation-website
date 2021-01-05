<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PasswordRequest extends Request {
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [];
    }
}


