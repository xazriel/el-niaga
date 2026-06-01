<?php

namespace App\Http\Controllers;

use App\Services\JneService;
use Illuminate\Support\Facades\Log;

class TrackingController extends Controller
{
    public function __construct(protected JneService $jne) {}

    /**
     * Tampilkan halaman tracking (blade view)
     */
    public function show(string $awb)
    {
        try {
            $data = $this->jne->trackPackage($awb);

            return view('tracking.show', [
                'cnote'   => $data['cnote']     ?? null,
                'detail'  => $data['detail'][0] ?? null,
                'history' => $data['history']   ?? [],
                'awb'     => $awb,
            ]);

        } catch (\Exception $e) {
            return back()->with('error', 'Nomor resi tidak ditemukan: ' . $e->getMessage());
        }
    }

    /**
     * Tracking via JSON response (untuk AJAX/API)
     */
    public function traceHistory(string $awb)
    {
        try {
            $result = $this->jne->trackPackage($awb);

            return response()->json([
                'success' => true,
                'summary' => $result['cnote']   ?? null,
                'detail'  => $result['detail']  ?? null,
                'history' => $result['history'] ?? [],
            ]);

        } catch (\Exception $e) {
            Log::error('JNE Tracking Error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Gagal menghubungkan ke server JNE.',
            ], 500);
        }
    }
}