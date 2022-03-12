<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Employees;

class EmployeeController extends Controller
{
    public function messages()
    {
        return [
            'name.required' => 'A title is required',
            'status_id.required' => 'A message is required',
        ];
    }

    public function create(Request $request)
    {
        $customMessages = [
            'required' => 'The :attribute field is required.'
        ];
        $request->validate([
            'name' => 'required|string|min:2|unique:Employees,name',
            'status_id' => 'required|integer|min:2000000|max:10000000|exists:references,id',
            'salary' => 'required',
        ], $customMessages);

        $model = new Employees;
        $model->name      = $request->name;
        $model->status_id = $request->status_id;
        $model->salary    = $request->salary;
        $model->save();

        return response()->json(['message' => 'Create employee success'], 202);
    }

    public function show(Request $request)
    {
        $request->validate([
            'per_page' => 'integer',
            'page' => 'integer',
            'order_by' => 'in:name,salary',
            'order_type' => 'in:ASC,DESC',
        ]);
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
    }
}
