<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OvertimeGetRequest extends FormRequest
{
    public function rules()
    {
        return [
            'date_started' => "required|date|before:$this->date_ended",
            'date_ended' => "required|date|after:$this->date_started",
        ];
    }
}
