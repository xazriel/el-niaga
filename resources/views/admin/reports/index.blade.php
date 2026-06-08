<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center font-helvetica">
            <h2 class="font-bold text-xs text-brand-primary tracking-widest uppercase">
                {{ __('Laporan Penjualan') }}
            </h2>
            <nav class="text-[9px] uppercase tracking-widest text-brand-olive font-bold">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-brand-primary">Dashboard</a> &gt; <span>Laporan</span>
            </nav>
        </div>
    </x-slot>

    <div class="bg-brand-white min-h-screen py-8 px-4 sm:px-6 lg:px-8 font-helvetica rounded-[2rem]">
        <div class="max-w-7xl mx-auto">
            
            {{-- Header --}}
            <div class="mb-10">
                <h3 class="text-3xl font-light text-brand-black tracking-wide">Laporan Penjualan</h3>
                <p class="text-[10px] uppercase tracking-[0.2em] text-brand-olive mt-1">Gunakan filter di bawah ini untuk menganalisis data pesanan secara komprehensif</p>
            </div>

            {{-- Filters Form --}}
            <div class="bg-brand-light/20 p-8 rounded-[2rem] border border-brand-light mb-10">
                <form action="{{ route('admin.reports.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 items-end">
                    
                    <div>
                        <label class="block text-[9px] font-bold uppercase tracking-widest text-brand-olive mb-2">Tanggal Mulai</label>
                        <input type="date" name="start_date" value="{{ request('start_date') }}"
                            class="w-full bg-brand-white border border-brand-light rounded-2xl px-5 py-3 text-[11px] focus:outline-none focus:ring-1 focus:ring-brand-primary">
                    </div>

                    <div>
                        <label class="block text-[9px] font-bold uppercase tracking-widest text-brand-olive mb-2">Tanggal Selesai</label>
                        <input type="date" name="end_date" value="{{ request('end_date') }}"
                            class="w-full bg-brand-white border border-brand-light rounded-2xl px-5 py-3 text-[11px] focus:outline-none focus:ring-1 focus:ring-brand-primary">
                    </div>

                    <div>
                        <label class="block text-[9px] font-bold uppercase tracking-widest text-brand-olive mb-2">Status Pesanan</label>
                        <select name="status" class="w-full bg-brand-white border border-brand-light rounded-2xl px-5 py-3 text-[11px] focus:outline-none focus:ring-1 focus:ring-brand-primary">
                            <option value="">Semua Terbayar (Default)</option>
                            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending (Belum Bayar)</option>
                            <option value="success" {{ request('status') === 'success' ? 'selected' : '' }}>Success (Sudah Bayar)</option>
                            <option value="shipped" {{ request('status') === 'shipped' ? 'selected' : '' }}>Shipped (Dalam Pengiriman)</option>
                            <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed (Selesai)</option>
                            <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled (Dibatalkan)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-[9px] font-bold uppercase tracking-widest text-brand-olive mb-2">Metode Pembayaran</label>
                        <select name="payment_method" class="w-full bg-brand-white border border-brand-light rounded-2xl px-5 py-3 text-[11px] focus:outline-none focus:ring-1 focus:ring-brand-primary">
                            <option value="">Semua Metode</option>
                            <option value="midtrans" {{ request('payment_method') === 'midtrans' ? 'selected' : '' }}>Midtrans</option>
                            <option value="manual" {{ request('payment_method') === 'manual' ? 'selected' : '' }}>Manual</option>
                        </select>
                    </div>

                    <div class="lg:col-span-4 flex justify-end gap-4 mt-4">
                        <button type="submit" class="bg-brand-primary text-brand-white px-8 py-3.5 rounded-full text-[10px] font-bold uppercase tracking-[0.2em] hover:bg-brand-olive transition">Terapkan Filter</button>
                        <a href="{{ route('admin.reports.index') }}" class="border border-brand-light text-brand-black px-8 py-3.5 rounded-full text-[10px] font-bold uppercase tracking-[0.2em] hover:bg-brand-light transition flex items-center justify-center">Reset</a>
                    </div>

                </form>
            </div>

            {{-- Summary Cards --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8 mb-12">
                <div class="bg-brand-light/30 p-8 rounded-[2rem] border border-brand-light">
                    <p class="text-brand-olive text-[8px] uppercase tracking-widest font-black">Total Pendapatan Bersih (Net)</p>
                    <h3 class="text-2xl font-bold text-brand-black mt-3">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
                    <p class="text-[8px] text-brand-olive mt-1 uppercase tracking-widest">{{ $ordersCount }} Transaksi Sukses</p>
                </div>
                <div class="bg-brand-light/30 p-8 rounded-[2rem] border border-brand-light">
                    <p class="text-brand-olive text-[8px] uppercase tracking-widest font-black">Pendapatan Nilai Produk</p>
                    <h3 class="text-2xl font-bold text-brand-black mt-3">Rp {{ number_format($totalItemsCost, 0, ',', '.') }}</h3>
                    <p class="text-[8px] text-brand-olive mt-1 uppercase tracking-widest">Ongkos Kirim JNE: Rp {{ number_format($totalShippingCost, 0, ',', '.') }}</p>
                </div>
                <div class="bg-brand-light/30 p-8 rounded-[2rem] border border-brand-light">
                    <p class="text-brand-olive text-[8px] uppercase tracking-widest font-black">Total Biaya Diskon / CRM</p>
                    <h3 class="text-2xl font-bold text-red-600 mt-3">Rp {{ number_format($totalPointsDiscount + $totalVoucherDiscount, 0, ',', '.') }}</h3>
                    <p class="text-[8px] text-brand-olive mt-1 uppercase tracking-widest">Point: Rp {{ number_format($totalPointsDiscount, 0, ',', '.') }} | Voucher: Rp {{ number_format($totalVoucherDiscount, 0, ',', '.') }}</p>
                </div>
            </div>

            {{-- Table --}}
            <div class="bg-brand-white rounded-[2rem] border border-brand-light overflow-hidden shadow-sm">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-brand-light/30 border-b border-brand-light text-[9px] uppercase tracking-[0.2em] text-brand-olive font-black">
                                <th class="py-5 px-6">No. Order</th>
                                <th class="py-5 px-6">Pelanggan</th>
                                <th class="py-5 px-6 text-center">Metode</th>
                                <th class="py-5 px-6 text-center">Status</th>
                                <th class="py-5 px-6 text-right">Nilai Produk</th>
                                <th class="py-5 px-6 text-right">Ongkir</th>
                                <th class="py-5 px-6 text-right">Diskon</th>
                                <th class="py-5 px-8 text-right">Total Bersih</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-brand-light text-[11px] text-brand-black">
                            @forelse($orders as $order)
                                <tr class="hover:bg-brand-light/10 transition">
                                    <td class="py-5 px-6 font-mono font-bold">
                                        <a href="{{ route('admin.orders.show', $order->order_number) }}" class="hover:underline text-brand-primary">#{{ $order->order_number }}</a>
                                        <span class="block text-[8px] text-brand-olive font-normal mt-0.5">{{ $order->created_at->format('d M Y H:i') }}</span>
                                    </td>
                                    <td class="py-5 px-6">
                                        <span class="font-bold block">{{ $order->user->name ?? $order->receiver_name }}</span>
                                        <span class="text-[9px] text-brand-olive block">{{ $order->user->email ?? $order->receiver_phone }}</span>
                                    </td>
                                    <td class="py-5 px-6 text-center font-bold uppercase text-[9px] text-brand-olive">
                                        {{ $order->payment_method }}
                                    </td>
                                    <td class="py-5 px-6 text-center">
                                        @php
                                            $statusStyles = [
                                                'pending'   => 'background:#FFFBEB; color:#B45309;',
                                                'success'   => 'background:#F0FDF4; color:#15803D;',
                                                'cancelled' => 'background:#FEF2F2; color:#B91C1C;',
                                                'shipped'   => 'background:#EFF6FF; color:#1D4ED8;',
                                            ];
                                            $s = $statusStyles[$order->status] ?? 'background:var(--light-gray); color:var(--olive-tint);';
                                        @endphp
                                        <span class="inline-block px-2.5 py-0.5 rounded text-[8px] font-bold uppercase tracking-widest" style="{{ $s }}">{{ $order->status }}</span>
                                    </td>
                                    <td class="py-5 px-6 text-right font-medium">
                                        Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                    </td>
                                    <td class="py-5 px-6 text-right text-brand-olive">
                                        Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}
                                    </td>
                                    <td class="py-5 px-6 text-right text-red-600 font-medium">
                                        @if(($order->points_discount + $order->voucher_discount) > 0)
                                            - Rp {{ number_format($order->points_discount + $order->voucher_discount, 0, ',', '.') }}
                                        @else
                                            Rp 0
                                        @endif
                                    </td>
                                    <td class="py-5 px-8 text-right font-bold text-[12px] text-brand-primary">
                                        Rp {{ number_format($order->grand_total, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="py-16 text-center text-brand-olive uppercase tracking-widest text-[10px]">Tidak ada pesanan yang sesuai dengan kriteria filter.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($orders->hasPages())
                    <div class="px-8 py-5 border-t border-brand-light bg-brand-light/10">
                        {{ $orders->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
