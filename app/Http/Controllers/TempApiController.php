<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Temp;
use Illuminate\Support\Facades\Validator;

class TempApiController extends Controller
{
    public function store(Request $request)
    {
        // 1. 簡易 API KEY チェック
        $apiKey = $request->header('X-API-KEY') ?? $request->input('api_key');
        if ($apiKey !== env('RASPI_API_KEY')) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized: Invalid API Key'
            ], 401);
        }

        // 2. 入力バリデーション
        $validator = Validator::make($request->all(), [
            'device_id' => 'required|integer|exists:device,device_id',
            'in_temp'   => 'required|numeric|between:-99.9,99.9',
            'out_temp'  => 'nullable|numeric|between:-99.9,99.9',
            'humidity'  => 'nullable|numeric|between:0,100',
            'solar'     => 'nullable|integer',
            'get_time'  => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        // 3. データベースへ保存
        $temp = Temp::create([
            'device_id' => $request->device_id,
            'in_temp'   => $request->in_temp,
            'out_temp'  => $request->out_temp,
            'humidity'  => $request->humidity,
            'solar'     => $request->solar,
            'get_time'  => $request->get_time,
            'send_time' => now(),
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Data recorded successfully',
            'data'    => $temp
        ], 201);
    }
}