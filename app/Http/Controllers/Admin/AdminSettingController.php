<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class AdminSettingController extends Controller
{
    public function index()
    {
        $settings = [
            'loyalty_spend_per_point_rate' => Setting::get('loyalty_spend_per_point_rate', '10000'),
            'loyalty_point_value_rate' => Setting::get('loyalty_point_value_rate', '1000'),
            'slow_moving_threshold_days' => Setting::get('slow_moving_threshold_days', '30'),
            'slow_moving_max_sold' => Setting::get('slow_moving_max_sold', '5'),
        ];

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'loyalty_spend_per_point_rate' => 'required|numeric|min:1',
            'loyalty_point_value_rate' => 'required|numeric|min:1',
            'slow_moving_threshold_days' => 'required|integer|min:1',
            'slow_moving_max_sold' => 'required|integer|min:0',
        ]);

        Setting::set('loyalty_spend_per_point_rate', $request->loyalty_spend_per_point_rate);
        Setting::set('loyalty_point_value_rate', $request->loyalty_point_value_rate);
        Setting::set('slow_moving_threshold_days', $request->slow_moving_threshold_days);
        Setting::set('slow_moving_max_sold', $request->slow_moving_max_sold);

        return back()->with('success', 'Pengaturan berhasil diperbarui!');
    }
}
