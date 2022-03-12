<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\References;

class SettingPatchRequest extends FormRequest
{

    public function rules()
    {
        return [
            'key' => 'required|in:overtime_method',
            'value' => [
                'required',
                Rule::exists('references', 'id')->where(function ($query) {
                    return $query->where('code', 'overtime_method');
                }),
            ]
        ];
    }
}
