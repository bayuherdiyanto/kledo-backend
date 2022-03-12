<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Settings;
use Illuminate\Support\Carbon;

class OvertimeCalculateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */

    public function toArray($request)
    {
        $setting = Settings::find("overtime_method");
        $start  = new Carbon($this->time_started);
        $end    = new Carbon($this->time_ended);
        $duration = (int)$start->diff($end)->format('%H');
        if ($this->status_id == 4) {
            $duration--;
        }
        $expression = "";
        if ($duration > 0) {
            $expression = str_replace("salary", $this->salary, $setting->expression);
            $expression = str_replace("overtime_duration_total", $duration, $expression);
        }
        $bonus = 0;
        if ($expression != "") {
            $bonus = eval("return $expression;");
        }

        // $expression = "5*5";
        return [
            'id' => $this->id,
            'name' => $this->employee_name,
            'status_id' => $this->status_id,
            'status' => [
                'name' => $this->status_employee
            ],
            'salary' => $this->salary,
            'overtimes' => [
                'id' => '',
                'date' => '',
                'time_started' => $this->time_started,
                'time_ended' => $this->time_ended,
                'bonus' => $bonus,
            ]
        ];
    }
}
