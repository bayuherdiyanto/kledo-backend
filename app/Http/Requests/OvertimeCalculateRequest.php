<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OvertimeCalculateRequest extends FormRequest
{
    public function rules()
    {
        return [
            'month' => "required|date|date_format:Y-m",
        ];
    }
}
