<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SettingPatchRequest;
use App\Models\Settings;

class SettingController extends Controller
{
    public function update(SettingPatchRequest $request)
    {
        $model = Settings::find('overtime_method');
        $model->key   = $request->key;
        $model->value = $request->value;
        $model->save();
        return response()->json(['message' => 'Setting update success'], 202);
    }
}
