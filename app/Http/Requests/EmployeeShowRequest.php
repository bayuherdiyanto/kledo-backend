<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeShowRequest extends FormRequest
{
    public function rules()
    {
        return [
            'per_page' => 'integer',
            'page' => 'integer',
            'order_by' => 'in:name,salary',
            'order_type' => 'in:ASC,DESC',
        ];
    }
}
