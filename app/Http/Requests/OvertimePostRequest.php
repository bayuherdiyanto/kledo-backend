<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OvertimePostRequest extends FormRequest
{
    public function rules()
    {
        $employee_id = $this->employee_id;
        return [
            'employee_id' => 'required|exists:employees,id',
            'date' => [
                'required',
                'date',
                Rule::unique('overtimes')->where(function ($query) use ($employee_id) {
                    return $query->where('employee_id', $employee_id);
                })
            ],
            'time_started' => "required|date_format:H:i|before:$this->time_ended",
            'time_ended' => "required|date_format:H:i|after:$this->time_started",
        ];
    }
}
