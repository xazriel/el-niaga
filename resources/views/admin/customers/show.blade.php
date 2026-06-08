<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center font-helvetica">
            <h2 class="font-bold text-xs text-brand-primary tracking-widest uppercase">
                {{ __('Profil Pelanggan') }}
            </h2>
            <nav class="text-[9px] uppercase tracking-widest text-brand-olive font-bold">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-brand-primary">Dashboard</a> &gt; 
                <a href="{{ route('admin.customers.index') }}" class="hover:text-brand-primary">Pelanggan</a> &gt; 
                <span>{{ $customer->name }}</span>
            </nav>
        </div>
    </x-slot>

    <div class="bg-brand-white min-h-screen py-8 px-4 sm:px-6 lg:px-8 font-helvetica rounded-[2rem]">
        <div class="max-w-7xl mx-auto">

            @if(session('success'))
                <div class="mb-8 p-5 rounded-2xl bg-brand-primary text-brand-white text-[10px] font-bold uppercase tracking-widest flex justify-between items-center">
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-8 p-5 rounded-2xl bg-red-600 text-brand-white text-[10px] font-bold uppercase tracking-widest flex justify-between items-center">
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            {{-- Back button --}}
            <a href="{{ route('admin.customers.index') }}" class="inline-flex items-center gap-2 text-[10px] font-bold text-brand-olive hover:text-brand-primary uppercase tracking-widest mb-8">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali ke Daftar
            </a>

            {{-- Customer Card Grid --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-12">
                
                {{-- Left profile info card --}}
                <div class="bg-brand-light/20 p-8 rounded-[2rem] border border-brand-light flex flex-col justify-between">
                    <div>
                        <span class="inline-block bg-brand-primary text-brand-white text-[9px] font-black tracking-widest px-4 py-1.5 rounded-full mb-6">PROFIL PELANGGAN</span>
                        <h3 class="text-3xl font-light text-brand-black tracking-tight mb-2">{{ $customer->name }}</h3>
                        <p class="text-[11px] text-brand-olive tracking-wider">{{ $customer->email }}</p>
                        <p class="text-[11px] text-brand-olive tracking-wider mt-1">{{ $customer->phone ?? 'Belum ada nomor HP' }}</p>
                        
                        <div class="h-px bg-brand-light my-6"></div>
                        
                        <div class="space-y-4">
                            <div>
                                <p class="text-[9px] text-brand-olive uppercase tracking-widest font-black">Poin Loyalty Saat Ini</p>
                                <p class="text-2xl font-bold text-brand-primary mt-1">{{ $customer->points }} PTS</p>
                            </div>
                            <div>
                                <p class="text-[9px] text-brand-olive uppercase tracking-widest font-black">Total Transaksi Selesai</p>
                                <p class="text-xl font-bold text-brand-black mt-1">Rp {{ number_format($customer->orders_sum_grand_total ?? 0, 0, ',', '.') }}</p>
                                <p class="text-[9px] text-brand-olive mt-1">{{ $customer->orders_count }} Transaksi Sukses</p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-8 text-[9px] text-brand-olive uppercase tracking-widest font-medium">
                        Terdaftar Sejak: {{ $customer->created_at->format('d F Y') }}
                    </div>
                </div>

                {{-- Middle: Loyalty Points manual adjustment form --}}
                <div class="bg-brand-white p-8 rounded-[2rem] border border-brand-light shadow-sm">
                    <h4 class="text-[10px] font-black uppercase tracking-[0.2em] text-brand-primary mb-6">Sesuaikan Poin Manual</h4>
                    <form action="{{ route('admin.loyalty.adjust', $customer->id) }}" method="POST" class="space-y-6">
                        @csrf
                        <input type="hidden" name="type" value="manual">

                        <div>
                            <label class="block text-[9px] font-bold uppercase tracking-widest text-brand-olive mb-2">Jumlah Poin (Gunakan tanda - untuk mengurangi)</label>
                            <input type="number" name="points" required placeholder="Contoh: 10 atau -10"
                                class="w-full bg-brand-light/30 border border-brand-light rounded-2xl px-5 py-3 text-[11px] placeholder-brand-olive/60 focus:outline-none focus:ring-1 focus:ring-brand-primary">
                        </div>

                        <div>
                            <label class="block text-[9px] font-bold uppercase tracking-widest text-brand-olive mb-2">Alasan Penyesuaian</label>
                            <input type="text" name="description" required placeholder="Contoh: Bonus Pendaftaran, Refund Transaksi, dll"
                                class="w-full bg-brand-light/30 border border-brand-light rounded-2xl px-5 py-3 text-[11px] placeholder-brand-olive/60 focus:outline-none focus:ring-1 focus:ring-brand-primary">
                        </div>

                        <button type="submit" class="w-full bg-brand-black text-brand-white py-4 rounded-full text-[10px] font-bold uppercase tracking-[0.2em] hover:bg-brand-primary transition">Simpan Perubahan Poin</button>
                    </form>
                </div>

                {{-- Right: Default Address card --}}
                <div class="bg-brand-white p-8 rounded-[2rem] border border-brand-light shadow-sm">
                    <h4 class="text-[10px] font-black uppercase tracking-[0.2em] text-brand-primary mb-6">Alamat Utama</h4>
                    @if($customer->defaultAddress)
                        <div class="space-y-3">
                            <span class="inline-block bg-brand-light text-brand-black text-[9px] font-bold uppercase tracking-widest px-3 py-1 rounded">{{ $customer->defaultAddress->label }}</span>
                            <p class="text-[12px] font-bold">{{ $customer->defaultAddress->recipient_name }}</p>
                            <p class="text-[11px] text-brand-olive">{{ $customer->defaultAddress->phone }}</p>
                            
                            <div class="h-px bg-brand-light my-4"></div>
                            
                            <p class="text-[11px] text-brand-black font-medium leading-relaxed">{{ $customer->defaultAddress->address }}</p>
                            <p class="text-[11px] text-brand-olive">{{ $customer->defaultAddress->district_name }}, {{ $customer->defaultAddress->city_name }}</p>
                            <p class="text-[11px] text-brand-olive">{{ $customer->defaultAddress->province_name }} — {{ $customer->defaultAddress->postal_code }}</p>
                        </div>
                    @else
                        <div class="py-16 text-center text-brand-olive text-[10px] uppercase tracking-widest">Belum ada alamat tersimpan.</div>
                    @endif
                </div>

            </div>

            {{-- Tabs / Section grids --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                
                {{-- Left: Loyalty Points Transactions log --}}
                <div class="bg-brand-white p-8 border border-brand-light rounded-[2.5rem]">
                    <h4 class="text-[11px] font-black uppercase tracking-[0.2em] text-brand-primary mb-6">Riwayat Poin</h4>
                    <div class="h-[400px] overflow-y-auto custom-scrollbar">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="border-b border-brand-light text-[8px] uppercase tracking-[0.2em] text-brand-olive font-bold">
                                    <th class="pb-3">Tanggal</th>
                                    <th class="pb-3">Keterangan</th>
                                    <th class="pb-3">Tipe</th>
                                    <th class="pb-3 text-right">Poin</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-brand-light text-[10px]">
                                @forelse($loyaltyTransactions as $lt)
                                    <tr>
                                        <td class="py-4 text-brand-olive">{{ $lt->created_at->format('d M Y H:i') }}</td>
                                        <td class="py-4">
                                            <span class="font-bold block">{{ $lt->description }}</span>
                                            @if($lt->order)
                                                <span class="text-[8px] text-brand-olive font-mono block mt-0.5">Order ID: {{ $lt->order->order_number }}</span>
                                            @endif
                                        </td>
                                        <td class="py-4 font-bold uppercase tracking-widest text-[8px] text-brand-olive">{{ $lt->type }}</td>
                                        <td class="py-4 text-right font-bold {{ $lt->points > 0 ? 'text-brand-primary' : 'text-red-600' }}">
                                            {{ $lt->points > 0 ? '+' : '' }}{{ $lt->points }} PTS
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="py-12 text-center text-brand-olive uppercase tracking-widest">Belum ada transaksi poin.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Right: Customer Order log --}}
                <div class="bg-brand-white p-8 border border-brand-light rounded-[2.5rem]">
                    <h4 class="text-[11px] font-black uppercase tracking-[0.2em] text-brand-primary mb-6">Riwayat Transaksi</h4>
                    <div class="h-[400px] overflow-y-auto custom-scrollbar">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="border-b border-brand-light text-[8px] uppercase tracking-[0.2em] text-brand-olive font-bold">
                                    <th class="pb-3">No. Pesanan</th>
                                    <th class="pb-3">Tanggal</th>
                                    <th class="pb-3 text-center">Status</th>
                                    <th class="pb-3 text-right">Total Belanja</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-brand-light text-[10px]">
                                @forelse($orders as $order)
                                    <tr>
                                        <td class="py-4 font-bold font-mono">
                                            <a href="{{ route('admin.orders.show', $order->order_number) }}" class="hover:underline text-brand-primary">#{{ $order->order_number }}</a>
                                        </td>
                                        <td class="py-4 text-brand-olive">{{ $order->created_at->format('d M Y') }}</td>
                                        <td class="py-4 text-center">
                                            @php
                                                $statusStyles = [
                                                    'pending'   => 'background:#FFFBEB; color:#B45309;',
                                                    'success'   => 'background:#F0FDF4; color:#15803D;',
                                                    'cancelled' => 'background:#FEF2F2; color:#B91C1C;',
                                                    'shipped'   => 'background:#EFF6FF; color:#1D4ED8;',
                                                ];
                                                $s = $statusStyles[$order->status] ?? 'background:var(--light-gray); color:var(--olive-tint);';
                                            @endphp
                                            <span class="inline-block px-3 py-1 rounded-full text-[8px] font-bold uppercase tracking-widest" style="{{ $s }}">{{ $order->status }}</span>
                                        </td>
                                        <td class="py-4 text-right font-bold">Rp {{ number_format($order->grand_total, 0, ',', '.') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="py-12 text-center text-brand-olive uppercase tracking-widest">Belum ada transaksi.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>
