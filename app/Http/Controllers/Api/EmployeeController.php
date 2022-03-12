<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeeCreateRequest;
use App\Http\Requests\EmployeeShowRequest;
use App\Http\Resources\EmployeeShowResource;
use App\Models\Employees;

class EmployeeController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/employee/",
     *     summary="Insert employee",
     *      @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="name",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="status_id",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="salary",
     *                     type="string"
     *                 ),
     *                 example={"name": "Bayu Herdiyanto", "status_id": "3", "salary": "2000000"}
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
    public function create(EmployeeCreateRequest $request)
    {
        $model = new Employees;
        $model->name      = $request->name;
        $model->status_id = $request->status_id;
        $model->salary    = $request->salary;
        $model->save();
        return response()->json(['message' => 'Create employee success'], 202);
    }
    /**
     * @OA\Get(
     *     path="/api/employee?per_page={per_page}&order_by={order_by}&order_type={order_type}",
     *      @OA\Parameter(
     *         in="path",
     *         name="per_page",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         in="path",
     *         name="order_by",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         in="path",
     *         name="order_type",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     summary="Get employee pagination",
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
    public function show(EmployeeShowRequest $request)
    {
        $per_page = ($request->per_page) ? $request->per_page : 10;
        $order_by = ($request->order_by) ? $request->order_by : 'name';
        $order_type = ($request->order_type) ? $request->order_type : 'asc';
        $model = Employees::select(
            'employees.id',
            'employees.name',
            'employees.status_id',
            'r.name as status_name',
            'employees.salary',
        )->join('references as r', 'r.id', 'employees.status_id')
            ->orderBy($order_by, $order_type)
            // ->offset(0)
            // ->limit(2)
            // ->get();
            ->simplePaginate($per_page);
        return response()->json($model, 202);

        return response()->json(EmployeeShowResource::collection($model), 202);
    }
}
