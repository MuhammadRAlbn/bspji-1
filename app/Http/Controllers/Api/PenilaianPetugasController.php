<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pelayanan;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PenilaianPetugasController extends Controller
{
    /**
     * Menyimpan data petugas terpilih.
     *
     * Menerima POST request dengan parameter:
     * - petugas_upp (string, required) — nama petugas yang dipilih
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'petugas_upp' => 'required|string|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validasi gagal',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $pelayanan = Pelayanan::create([
                'petugas_upp' => $request->input('petugas_upp'),
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Data petugas berhasil disimpan',
                'data' => $pelayanan,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menyimpan data: '.$e->getMessage(),
            ], 500);
        }
    }
}
