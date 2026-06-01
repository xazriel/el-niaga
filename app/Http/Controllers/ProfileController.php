<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function index()
    {
        $orders = auth()->user()->orders()
            ->with(['items.product'])
            ->latest()
            ->get();

        return view('dashboard', compact('orders'));
    }

    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    public function orderDetail($order_number): View
    {
        $order = Order::with(['items.product'])
            ->where('order_number', $order_number)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('profile.order-detail', compact('order'));
    }

    public function updateAddress(Request $request): RedirectResponse
    {
        $request->validate([
            'phone'            => ['required', 'string', 'max:20'],
            'address'          => ['required', 'string'],
            'destination_id'   => ['required', 'string'],
            'destination_name' => ['required', 'string'],
        ]);

        $request->user()->update([
            'phone'            => $request->phone,
            'address'          => $request->address,
            'destination_id'   => $request->destination_id,
            'destination_name' => $request->destination_name,
        ]);

        return Redirect::route('dashboard')->with('status', 'address-updated');
    }

    /**
     * Tracking resi via JNE API — dipanggil dari dashboard via fetch()
     */
    public function trackResi($awb)
    {
        $url = config('jne.url_tracking') . '/tracing/api/list/v1/cnote/' . $awb;

        try {
            $response = Http::withoutVerifying()
                ->withHeaders([
                    'Accept'     => 'application/json',
                    'User-Agent' => 'Laravel-Request',
                ])
                ->asForm()
                ->timeout(15)
                ->post($url, [
                    'username' => config('jne.username'),
                    'api_key'  => config('jne.api_key'),
                ]);

            Log::info('JNE Track', [
                'awb'  => $awb,
                'url'  => $url,
                'http' => $response->status(),
                'body' => $response->body(),
            ]);

            if ($response->failed()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal terhubung ke server JNE (HTTP ' . $response->status() . ').',
                ], 500);
            }

            $data = $response->json();

            if (isset($data['status']) && $data['status'] === false) {
                return response()->json([
                    'success' => false,
                    'message' => $data['error'] ?? 'Resi tidak ditemukan.',
                ]);
            }

            if (isset($data['cnote'])) {
                $cnote  = $data['cnote'];
                $detail = $data['detail'][0] ?? [];

                return response()->json([
                    'success'       => true,
                    'status'        => $cnote['pod_status']          ?? 'ON PROCESS',
                    'last'          => $cnote['last_status']         ?? '',
                    'pod_status'    => $cnote['pod_status']          ?? '',
                    'shipper'       => $detail['cnote_shipper_name'] ?? '',
                    'shipper_city'  => $detail['cnote_shipper_city'] ?? '',
                    'receiver'      => $cnote['cnote_receiver_name'] ?? '',
                    'receiver_city' => $cnote['city_name']           ?? '',
                    'service'       => $cnote['cnote_services_code'] ?? '',
                    'estimate'      => $cnote['estimate_delivery']   ?? '',
                    'history'       => $data['history']              ?? [],
                ]);
            }

            Log::warning('JNE Track: struktur tidak dikenal', ['data' => $data]);

            return response()->json([
                'success' => false,
                'message' => 'Format response API tidak dikenali.',
            ], 500);

        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            Log::error('JNE Track: Connection timeout', ['awb' => $awb]);

            return response()->json([
                'success' => false,
                'message' => 'Koneksi ke server JNE timeout. Coba beberapa saat lagi.',
            ], 504);

        } catch (\Exception $e) {
            Log::error('JNE Track Exception', [
                'awb'     => $awb,
                'message' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem.',
            ], 500);
        }
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();
        Auth::logout();
        $user->delete();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}