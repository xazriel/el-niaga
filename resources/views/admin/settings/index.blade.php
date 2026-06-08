<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center font-helvetica">
            <h2 class="font-bold text-xs text-brand-primary tracking-widest uppercase">
                {{ __('Pengaturan Toko & CRM') }}
            </h2>
            <nav class="text-[9px] uppercase tracking-widest text-brand-olive font-bold">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-brand-primary">Dashboard</a> &gt; <span>Pengaturan</span>
            </nav>
        </div>
    </x-slot>

    <div class="bg-brand-white min-h-screen py-8 px-4 sm:px-6 lg:px-8 font-helvetica rounded-[2rem]">
        <div class="max-w-3xl mx-auto">

            @if(session('success'))
                <div class="mb-8 p-5 rounded-2xl bg-brand-primary text-brand-white text-[10px] font-bold uppercase tracking-widest flex justify-between items-center">
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <div class="mb-10">
                <h3 class="text-3xl font-light text-brand-black tracking-wide">Pengaturan Sistem</h3>
                <p class="text-[10px] uppercase tracking-[0.2em] text-brand-olive mt-1">Sesuaikan formula kalkulasi loyalty point dan ambang batas deteksi produk lambat terjual</p>
            </div>

            <div class="bg-brand-white p-8 rounded-[2rem] border border-brand-light shadow-sm">
                <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-8">
                    @csrf
                    @method('PUT')

                    {{-- Loyalty CRM Section --}}
                    <div>
                        <h4 class="text-[11px] font-black uppercase tracking-[0.2em] text-brand-primary border-b border-brand-light pb-3 mb-6">Konfigurasi Loyalty Point</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-[9px] font-bold uppercase tracking-widest text-brand-olive mb-2">Nilai Belanja Per 10 Poin (Rp)</label>
                                <input type="number" name="loyalty_spend_per_point_rate" required value="{{ $settings['loyalty_spend_per_point_rate'] }}"
                                    class="w-full bg-brand-light/20 border border-brand-light rounded-2xl px-5 py-3 text-[12px] focus:outline-none focus:ring-1 focus:ring-brand-primary">
                                <span class="text-[8px] text-brand-olive mt-1 block">Rasio bawaan: Rp 100.000 (Setiap kelipatan Rp 10.000 = 1 poin).</span>
                            </div>
                            
                            <div>
                                <label class="block text-[9px] font-bold uppercase tracking-widest text-brand-olive mb-2">Nilai 1 Poin Untuk Diskon (Rp)</label>
                                <input type="number" name="loyalty_point_value_rate" required value="{{ $settings['loyalty_point_value_rate'] }}"
                                    class="w-full bg-brand-light/20 border border-brand-light rounded-2xl px-5 py-3 text-[12px] focus:outline-none focus:ring-1 focus:ring-brand-primary">
                                <span class="text-[8px] text-brand-olive mt-1 block">Rasio bawaan: Rp 1.000 (1 poin memotong tagihan Rp 1.000).</span>
                            </div>
                        </div>
                    </div>

                    {{-- Business Intelligence Clearance Section --}}
                    <div class="pt-4">
                        <h4 class="text-[11px] font-black uppercase tracking-[0.2em] text-brand-primary border-b border-brand-light pb-3 mb-6">Konfigurasi Pendeteksi Slow-Moving (Cuci Gudang)</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-[9px] font-bold uppercase tracking-widest text-brand-olive mb-2">Umur Minimal Produk (Hari)</label>
                                <input type="number" name="slow_moving_threshold_days" required value="{{ $settings['slow_moving_threshold_days'] }}"
                                    class="w-full bg-brand-light/20 border border-brand-light rounded-2xl px-5 py-3 text-[12px] focus:outline-none focus:ring-1 focus:ring-brand-primary">
                                <span class="text-[8px] text-brand-olive mt-1 block">Produk terdaftar lebih lama dari jumlah hari ini akan dianalisis.</span>
                            </div>

                            <div>
                                <label class="block text-[9px] font-bold uppercase tracking-widest text-brand-olive mb-2">Batas Maksimal Penjualan (Qty)</label>
                                <input type="number" name="slow_moving_max_sold" required value="{{ $settings['slow_moving_max_sold'] }}"
                                    class="w-full bg-brand-light/20 border border-brand-light rounded-2xl px-5 py-3 text-[12px] focus:outline-none focus:ring-1 focus:ring-brand-primary">
                                <span class="text-[8px] text-brand-olive mt-1 block">Jika produk terjual kurang dari kuantitas ini, maka direkomendasikan diskon cuci gudang.</span>
                            </div>
                        </div>
                    </div>

                    <div class="pt-6">
                        <button type="submit" class="w-full bg-brand-black text-brand-white py-4 rounded-full text-[10px] font-bold uppercase tracking-[0.2em] hover:bg-brand-primary transition-all duration-300">Perbarui Parameter Sistem</button>
                    </div>

                </form>
            </div>

        </div>
    </div>
</x-app-layout>
