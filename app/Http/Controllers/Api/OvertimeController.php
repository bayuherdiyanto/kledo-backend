<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\OvertimeCalculateRequest;
use App\Http\Requests\OvertimeGetRequest;
use App\Http\Requests\OvertimePostRequest;
use App\Http\Resources\OvertimeCalculateResource;
use App\Http\Resources\OvertimeGetResource;
use App\Models\Overtimes;
use App\Models\Settings;

class OvertimeController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/overtime/",
     *     summary="Insert overtime",
     *      @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="employee_id",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="date",
     *                     type="date"
     *                 ),
     *                 @OA\Property(
     *                     property="time_started",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="time_ended",
     *                     type="string"
     *                 ),
     *                 example={
     *                      "employee_id": "1", 
     *                      "date": "2022-03-10", 
     *                      "time_started": "10:00",
     *                      "time_ended": "12:00"
     *                  }
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *          @OA\JsonContent(
     *             @OA\Examples(example="result", value={"success": true}, summary="An result object."),
     *             @OA\Examples(example="bool", value=false, summary="A boolean value."),
     *         )
     *     )
     * )
     */
    public function create(OvertimePostRequest $request)
    {
        $model = new Overtimes;
        $model->employee_id  = $request->employee_id;
        $model->date         = $request->date;
        $model->time_started = $request->time_started;
        $model->time_ended   = $request->time_ended;
        $model->save();
        return response()->json(['message' => 'Overtime create success'], 202);
    }
    /**
     * @OA\Get(
     *     path="/api/overtime?date_started={date_started}&date_ended={date_ended}",
     *      @OA\Parameter(
     *         in="path",
     *         name="date_started",
     *         required=false,
     *         @OA\Schema(type="date")
     *     ),
     *     @OA\Parameter(
     *         in="path",
     *         name="date_ended",
     *         required=false,
     *         @OA\Schema(type="date")
     *     ),
     *     summary="Get overtime",
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *          @OA\JsonContent(
     *             @OA\Examples(example="result", value={"success": true}, summary="An result object."),
     *             @OA\Examples(example="bool", value=false, summary="A boolean value."),
     *         )
     *     )
     * )
     */
    public function show(OvertimeGetRequest $request)
    {
        $model = Overtimes::select('overtimes.*', 'e.name as employee_name')
            ->join('employees as e', 'e.id', 'overtimes.employee_id')
            ->whereBetween(
                'overtimes.date',
                [$request->date_started, $request->date_ended]
            )->get();
        return response()->json(OvertimeGetResource::collection($model), 202);
    }
    /**
     * @OA\Get(
     *     path="/api/overtime-pays/calculate?month={month}",
     *      @OA\Parameter(
     *         in="path",
     *         name="month",
     *         required=false,
     *         @OA\Schema(type="date")
     *     ),
     *     summary="Get bonus",
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *          @OA\JsonContent(
     *             @OA\Examples(example="result", value={"success": true}, summary="An result object."),
     *             @OA\Examples(example="bool", value=false, summary="A boolean value."),
     *         )
     *     )
     * )
     */
    public function calculate(OvertimeCalculateRequest $request)
    {
        $setting = Settings::find("overtime_method");
        $model = Overtimes::select(
            'overtimes.*',
            'e.name as employee_name',
            'e.status_id',
            'r.name as status_employee',
            'e.salary'
        )->join('employees as e', 'e.id', 'overtimes.employee_id')
            ->join('references as r', 'r.id', 'e.status_id')
            ->where('overtimes.date', 'LIKE', "%$request->month%")
            ->get();

        return response()->json(OvertimeCalculateResource::collection($model, $setting->expression), 202);
    }
}
