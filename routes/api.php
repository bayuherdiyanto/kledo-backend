<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SettingController;
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\OvertimeController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::patch('settings', [SettingController::class, 'update']);
Route::post('employee', [EmployeeController::class, 'create']);
Route::get('employee', [EmployeeController::class, 'show']);
Route::post('overtime', [OvertimeController::class, 'create']);
Route::get('overtime', [OvertimeController::class, 'show']);
Route::get('overtime-pays/calculate', [OvertimeController::class, 'calculate']);
