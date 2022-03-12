<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Settings;

class SettingController extends Controller
{
    public function update(Request $request)
    {
        $validated = $request->validate([
            'key' => 'required|in:overtime_method',
            'value' => 'required|exists:references,id',
        ]);

        $model = Settings::find('overtime_method');
        $model->key   = $request->key;
        $model->value = $request->value;
        $model->save();
        return response()->json(['message' => 'Setting update success'], 202);
    }
}
