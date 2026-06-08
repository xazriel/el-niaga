<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center font-helvetica">
            <h2 class="font-bold text-xs text-brand-primary tracking-widest uppercase">
                {{ __('Kelola Voucher') }}
            </h2>
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.loyalty.index') }}" class="bg-brand-light text-brand-black px-6 py-2 rounded-full text-[9px] font-bold uppercase tracking-widest hover:bg-brand-primary hover:text-brand-white transition">Kembali ke Poin</a>
            </div>
        </div>
    </x-slot>

    <div class="bg-brand-white min-h-screen py-8 px-4 sm:px-6 lg:px-8 font-helvetica rounded-[2rem]">
        <div class="max-w-7xl mx-auto" x-data="{ editingVoucher: null }">

            @if(session('success'))
                <div class="mb-8 p-5 rounded-2xl bg-brand-primary text-brand-white text-[10px] font-bold uppercase tracking-widest flex justify-between items-center">
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                {{-- Create / Edit Form --}}
                <div class="bg-brand-light/20 p-8 rounded-[2rem] border border-brand-light">
                    
                    {{-- Form Tambah --}}
                    <div x-show="!editingVoucher">
                        <h4 class="text-[11px] font-black uppercase tracking-[0.2em] text-brand-primary mb-6">Tambah Voucher Baru</h4>
                        <form action="{{ route('admin.loyalty.vouchers.store') }}" method="POST" class="space-y-6">
                            @csrf
                            <div>
                                <label class="block text-[9px] font-bold uppercase tracking-widest text-brand-olive mb-2">Kode Voucher</label>
                                <input type="text" name="code" required placeholder="Contoh: DISKON50K"
                                    class="w-full bg-brand-white border border-brand-light rounded-2xl px-5 py-3 text-[11px] placeholder-brand-olive/55 focus:outline-none uppercase focus:ring-1 focus:ring-brand-primary">
                            </div>

                            <div>
                                <label class="block text-[9px] font-bold uppercase tracking-widest text-brand-olive mb-2">Tipe Potongan</label>
                                <select name="type" required class="w-full bg-brand-white border border-brand-light rounded-2xl px-5 py-3 text-[11px] focus:outline-none focus:ring-1 focus:ring-brand-primary">
                                    <option value="fixed">Nominal Tetap (Rupiah)</option>
                                    <option value="percent">Persentase (%)</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-[9px] font-bold uppercase tracking-widest text-brand-olive mb-2">Nilai Potongan</label>
                                <input type="number" name="value" required placeholder="Contoh: 50000 atau 10"
                                    class="w-full bg-brand-white border border-brand-light rounded-2xl px-5 py-3 text-[11px] placeholder-brand-olive/55 focus:outline-none focus:ring-1 focus:ring-brand-primary">
                            </div>

                            <div>
                                <label class="block text-[9px] font-bold uppercase tracking-widest text-brand-olive mb-2">Minimal Belanja (Rp)</label>
                                <input type="number" name="min_spend" required value="0"
                                    class="w-full bg-brand-white border border-brand-light rounded-2xl px-5 py-3 text-[11px] placeholder-brand-olive/55 focus:outline-none focus:ring-1 focus:ring-brand-primary">
                            </div>

                            <div>
                                <label class="block text-[9px] font-bold uppercase tracking-widest text-brand-olive mb-2">Masa Berlaku (Expired)</label>
                                <input type="datetime-local" name="expires_at"
                                    class="w-full bg-brand-white border border-brand-light rounded-2xl px-5 py-3 text-[11px] focus:outline-none focus:ring-1 focus:ring-brand-primary">
                            </div>

                            <div>
                                <label class="block text-[9px] font-bold uppercase tracking-widest text-brand-olive mb-2">Biaya Poin (PTS) (0 jika gratis)</label>
                                <input type="number" name="points_cost" required value="0"
                                    class="w-full bg-brand-white border border-brand-light rounded-2xl px-5 py-3 text-[11px] placeholder-brand-olive/55 focus:outline-none focus:ring-1 focus:ring-brand-primary">
                                <span class="text-[8px] text-brand-olive mt-1 block font-medium">Jika diisi > 0, customer harus menukarkan poin sebanyak nilai ini untuk mengklaim voucher.</span>
                            </div>

                            <div class="flex items-center gap-3">
                                <input type="checkbox" name="is_active" id="is_active" checked value="1" class="rounded text-brand-primary focus:ring-brand-primary">
                                <label for="is_active" class="text-[9px] font-bold uppercase tracking-widest text-brand-olive">Voucher Aktif</label>
                            </div>

                            <button type="submit" class="w-full bg-brand-black text-brand-white py-4 rounded-full text-[10px] font-bold uppercase tracking-[0.2em] hover:bg-brand-primary transition">Simpan Voucher</button>
                        </form>
                    </div>

                    {{-- Form Edit --}}
                    <div x-show="editingVoucher" style="display: none;">
                        <h4 class="text-[11px] font-black uppercase tracking-[0.2em] text-brand-primary mb-6">Edit Voucher</h4>
                        <form :action="'/admin/loyalty/vouchers/' + editingVoucher?.id" method="POST" class="space-y-6">
                            @csrf
                            @method('PUT')
                            <div>
                                <label class="block text-[9px] font-bold uppercase tracking-widest text-brand-olive mb-2">Kode Voucher</label>
                                <input type="text" name="code" required x-model="editingVoucher.code"
                                    class="w-full bg-brand-white border border-brand-light rounded-2xl px-5 py-3 text-[11px] focus:outline-none uppercase focus:ring-1 focus:ring-brand-primary">
                            </div>

                            <div>
                                <label class="block text-[9px] font-bold uppercase tracking-widest text-brand-olive mb-2">Tipe Potongan</label>
                                <select name="type" required x-model="editingVoucher.type" class="w-full bg-brand-white border border-brand-light rounded-2xl px-5 py-3 text-[11px] focus:outline-none focus:ring-1 focus:ring-brand-primary">
                                    <option value="fixed">Nominal Tetap (Rupiah)</option>
                                    <option value="percent">Persentase (%)</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-[9px] font-bold uppercase tracking-widest text-brand-olive mb-2">Nilai Potongan</label>
                                <input type="number" name="value" required x-model="editingVoucher.value"
                                    class="w-full bg-brand-white border border-brand-light rounded-2xl px-5 py-3 text-[11px] focus:outline-none focus:ring-1 focus:ring-brand-primary">
                            </div>

                            <div>
                                <label class="block text-[9px] font-bold uppercase tracking-widest text-brand-olive mb-2">Minimal Belanja (Rp)</label>
                                <input type="number" name="min_spend" required x-model="editingVoucher.min_spend"
                                    class="w-full bg-brand-white border border-brand-light rounded-2xl px-5 py-3 text-[11px] focus:outline-none focus:ring-1 focus:ring-brand-primary">
                            </div>

                            <div>
                                <label class="block text-[9px] font-bold uppercase tracking-widest text-brand-olive mb-2">Masa Berlaku (Expired)</label>
                                <input type="datetime-local" name="expires_at" x-model="editingVoucher.expires_at"
                                    class="w-full bg-brand-white border border-brand-light rounded-2xl px-5 py-3 text-[11px] focus:outline-none focus:ring-1 focus:ring-brand-primary">
                            </div>

                            <div>
                                <label class="block text-[9px] font-bold uppercase tracking-widest text-brand-olive mb-2">Biaya Poin (PTS) (0 jika gratis)</label>
                                <input type="number" name="points_cost" required x-model="editingVoucher.points_cost"
                                    class="w-full bg-brand-white border border-brand-light rounded-2xl px-5 py-3 text-[11px] focus:outline-none focus:ring-1 focus:ring-brand-primary">
                            </div>

                            <div class="flex items-center gap-3">
                                <input type="checkbox" name="is_active" id="edit_is_active" x-model="editingVoucher.is_active" value="1" class="rounded text-brand-primary focus:ring-brand-primary">
                                <label for="edit_is_active" class="text-[9px] font-bold uppercase tracking-widest text-brand-olive">Voucher Aktif</label>
                            </div>

                            <div class="flex gap-4">
                                <button type="submit" class="flex-1 bg-brand-black text-brand-white py-4 rounded-full text-[10px] font-bold uppercase tracking-[0.2em] hover:bg-brand-primary transition">Update</button>
                                <button type="button" @click="editingVoucher = null" class="flex-1 border border-brand-light text-brand-black py-4 rounded-full text-[10px] font-bold uppercase tracking-[0.2em] hover:bg-brand-light transition">Batal</button>
                            </div>
                        </form>
                    </div>

                </div>

                {{-- Voucher Lists --}}
                <div class="lg:col-span-2">
                    <div class="bg-brand-white rounded-[2rem] border border-brand-light overflow-hidden shadow-sm">
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="bg-brand-light/30 border-b border-brand-light text-[9px] uppercase tracking-[0.2em] text-brand-olive font-black">
                                        <th class="py-5 px-6">Kode</th>
                                        <th class="py-5 px-6">Potongan</th>
                                        <th class="py-5 px-6">Min. Belanja</th>
                                        <th class="py-5 px-6 text-center">Status</th>
                                        <th class="py-5 px-6 text-center">Biaya Poin</th>
                                        <th class="py-5 px-6">Expired</th>
                                        <th class="py-5 px-6 text-right">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-brand-light text-[11px] text-brand-black">
                                    @forelse($vouchers as $v)
                                        <tr class="hover:bg-brand-light/10 transition">
                                            <td class="py-5 px-6 font-bold font-mono text-[12px] tracking-wide text-brand-primary">{{ $v->code }}</td>
                                            <td class="py-5 px-6 font-bold">
                                                @if($v->type === 'fixed')
                                                    Rp {{ number_format($v->value, 0, ',', '.') }}
                                                @else
                                                    {{ number_format($v->value) }} %
                                                @endif
                                            </td>
                                            <td class="py-5 px-6 text-brand-olive">
                                                Rp {{ number_format($v->min_spend, 0, ',', '.') }}
                                            </td>
                                            <td class="py-5 px-6 text-center">
                                                @if($v->is_active && (!$v->expires_at || !$v->expires_at->isPast()))
                                                    <span class="inline-block bg-brand-primary text-brand-white px-2 py-0.5 rounded text-[8px] font-bold uppercase tracking-widest">AKTIF</span>
                                                @else
                                                    <span class="inline-block bg-red-100 text-red-700 px-2 py-0.5 rounded text-[8px] font-bold uppercase tracking-widest">NON-AKTIF</span>
                                                @endif
                                            </td>
                                            <td class="py-5 px-6 text-center font-bold">
                                                @if($v->points_cost > 0)
                                                    <span class="text-brand-primary">{{ $v->points_cost }} PTS</span>
                                                @else
                                                    <span class="text-brand-olive">Gratis</span>
                                                @endif
                                            </td>
                                            <td class="py-5 px-6 text-brand-olive">
                                                {{ $v->expires_at ? $v->expires_at->format('d M Y H:i') : '-' }}
                                            </td>
                                            <td class="py-5 px-6 text-right">
                                                <div class="flex justify-end gap-3">
                                                    <button type="button" 
                                                        @click="editingVoucher = {
                                                            id: {{ $v->id }},
                                                            code: '{{ $v->code }}',
                                                            type: '{{ $v->type }}',
                                                            value: {{ $v->value }},
                                                            min_spend: {{ $v->min_spend }},
                                                            expires_at: '{{ $v->expires_at ? $v->expires_at->format('Y-m-d\TH:i') : '' }}',
                                                            points_cost: {{ $v->points_cost }},
                                                            is_active: {{ $v->is_active ? 'true' : 'false' }}
                                                        }"
                                                        class="text-[9px] font-bold uppercase tracking-widest text-brand-primary hover:underline">Edit</button>
                                                    <span class="text-brand-light">|</span>
                                                    <form action="{{ route('admin.loyalty.vouchers.destroy', $v->id) }}" method="POST" onsubmit="return confirm('Hapus voucher ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-[9px] font-bold uppercase tracking-widest text-red-600 hover:underline">Hapus</button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="py-16 text-center text-brand-olive uppercase tracking-widest text-[10px]">Belum ada voucher dibuat.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>
