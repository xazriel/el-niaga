<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Voucher;
use App\Models\LoyaltyPointTransaction;
use Illuminate\Http\Request;

class AdminLoyaltyController extends Controller
{
    public function index(Request $request)
    {
        $transactions = LoyaltyPointTransaction::with('user', 'order')
            ->latest()
            ->paginate(20);

        return view('admin.loyalty.index', compact('transactions'));
    }

    public function adjust(Request $request, $userId)
    {
        $user = User::findOrFail($userId);

        $request->validate([
            'points' => 'required|integer|not_in:0',
            'type' => 'required|in:manual',
            'description' => 'required|string|max:255',
        ]);

        $points = (int) $request->points;

        // Validasi agar poin tidak negatif
        if (($user->points + $points) < 0) {
            return back()->with('error', 'Poin pelanggan tidak boleh kurang dari 0 setelah penyesuaian.');
        }

        $user->adjustPoints($points, 'manual', $request->description);

        return back()->with('success', "Berhasil menyesuaikan poin pelanggan sebanyak {$points} poin!");
    }

    // --- Vouchers CMS ---
    
    public function vouchersIndex()
    {
        $vouchers = Voucher::latest()->get();
        return view('admin.loyalty.vouchers', compact('vouchers'));
    }

    public function vouchersStore(Request $request)
    {
        $request->validate([
            'code' => 'required|string|unique:vouchers,code|max:50',
            'type' => 'required|in:fixed,percent',
            'value' => 'required|numeric|min:1',
            'min_spend' => 'required|numeric|min:0',
            'expires_at' => 'nullable|date',
            'points_cost' => 'required|integer|min:0',
        ]);

        Voucher::create([
            'code' => strtoupper($request->code),
            'type' => $request->type,
            'value' => $request->value,
            'min_spend' => $request->min_spend,
            'is_active' => $request->has('is_active'),
            'expires_at' => $request->expires_at,
            'points_cost' => $request->points_cost,
        ]);

        return back()->with('success', 'Voucher berhasil ditambahkan!');
    }

    public function vouchersUpdate(Request $request, $id)
    {
        $voucher = Voucher::findOrFail($id);

        $request->validate([
            'code' => 'required|string|max:50|unique:vouchers,code,' . $voucher->id,
            'type' => 'required|in:fixed,percent',
            'value' => 'required|numeric|min:1',
            'min_spend' => 'required|numeric|min:0',
            'expires_at' => 'nullable|date',
            'points_cost' => 'required|integer|min:0',
        ]);

        $voucher->update([
            'code' => strtoupper($request->code),
            'type' => $request->type,
            'value' => $request->value,
            'min_spend' => $request->min_spend,
            'is_active' => $request->has('is_active'),
            'expires_at' => $request->expires_at,
            'points_cost' => $request->points_cost,
        ]);

        return back()->with('success', 'Voucher berhasil diperbarui!');
    }

    public function vouchersDestroy($id)
    {
        $voucher = Voucher::findOrFail($id);
        $voucher->delete();

        return back()->with('success', 'Voucher berhasil dihapus!');
    }
}
