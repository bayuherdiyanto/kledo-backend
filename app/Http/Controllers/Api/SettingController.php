<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SettingPatchRequest;
use App\Models\Settings;

class SettingController extends Controller
{
    /**
     * @OA\Patch(
     *     path="/api/settings/",
     *     summary="Updates setting",
     *      @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="key",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="value",
     *                     type="string"
     *                 ),
     *                 example={"key": "overtime_method", "value": "1"}
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
    public function update(SettingPatchRequest $request)
    {
        $model = Settings::find('overtime_method');
        $model->key   = $request->key;
        $model->value = $request->value;
        $model->save();
        return response()->json(['message' => 'Setting update success'], 202);
    }
}
