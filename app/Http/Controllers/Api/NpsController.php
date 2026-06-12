<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TblNps;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NpsController extends Controller
{
    /**
     * Menyimpan skor NPS.
     *
     * Menerima POST request dengan parameter:
     * - nps (integer, required, 0-10) — skor Net Promoter Score
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'nps' => 'required|integer|min:0|max:10',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validasi gagal',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $nps = TblNps::create([
                'nps' => $request->input('nps'),
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Skor NPS berhasil disimpan',
                'data' => $nps,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menyimpan data: '.$e->getMessage(),
            ], 500);
        }
    }
}
