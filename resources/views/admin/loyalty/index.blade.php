<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center font-helvetica">
            <h2 class="font-bold text-xs text-brand-primary tracking-widest uppercase">
                {{ __('Riwayat Loyalty Point') }}
            </h2>
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.loyalty.vouchers') }}" class="bg-brand-black text-brand-white px-6 py-2 rounded-full text-[9px] font-bold uppercase tracking-widest hover:bg-brand-olive transition">Kelola Voucher</a>
            </div>
        </div>
    </x-slot>

    <div class="bg-brand-white min-h-screen py-8 px-4 sm:px-6 lg:px-8 font-helvetica rounded-[2rem]">
        <div class="max-w-7xl mx-auto">
            
            <div class="mb-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                <div>
                    <h3 class="text-2xl font-light text-brand-black tracking-wide">Loyalty Point Ledger</h3>
                    <p class="text-[10px] uppercase tracking-[0.2em] text-brand-olive mt-1">Laporan mutasi perolehan dan penggunaan poin seluruh pelanggan</p>
                </div>
            </div>

            <div class="bg-brand-white rounded-[2rem] border border-brand-light overflow-hidden shadow-sm">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-brand-light/30 border-b border-brand-light text-[9px] uppercase tracking-[0.2em] text-brand-olive font-black">
                                <th class="py-5 px-8">Pelanggan</th>
                                <th class="py-5 px-6">Tanggal</th>
                                <th class="py-5 px-6 text-center">Tipe Mutasi</th>
                                <th class="py-5 px-6">No. Pesanan</th>
                                <th class="py-5 px-6">Keterangan / Alasan</th>
                                <th class="py-5 px-8 text-right">Perubahan Poin</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-brand-light text-[11px] text-brand-black">
                            @forelse($transactions as $t)
                                <tr class="hover:bg-brand-light/10 transition">
                                    <td class="py-5 px-8">
                                        @if($t->user)
                                            <a href="{{ route('admin.customers.show', $t->user_id) }}" class="font-bold hover:underline text-brand-primary text-[12px] block">{{ $t->user->name }}</a>
                                            <span class="text-[9px] text-brand-olive font-mono">{{ $t->user->email }}</span>
                                        @else
                                            <span class="text-brand-olive font-italic">Pelanggan Terhapus</span>
                                        @endif
                                    </td>
                                    <td class="py-5 px-6 text-brand-olive">
                                        {{ $t->created_at->format('d M Y H:i') }}
                                    </td>
                                    <td class="py-5 px-6 text-center font-bold">
                                        @php
                                            $typeStyles = [
                                                'earn' => 'background:#F0FDF4; color:#16A34A;',
                                                'redeem' => 'background:#FEF2F2; color:#DC2626;',
                                                'manual' => 'background:#EFF6FF; color:#2563EB;',
                                                'refund' => 'background:#FFFBEB; color:#D97706;',
                                            ];
                                            $style = $typeStyles[$t->type] ?? 'background:#F3F4F6; color:#4B5563;';
                                        @endphp
                                        <span class="inline-block px-3 py-1 rounded-full text-[8px] font-bold uppercase tracking-widest" style="{{ $style }}">{{ $t->type }}</span>
                                    </td>
                                    <td class="py-5 px-6 font-mono font-medium">
                                        @if($t->order)
                                            <a href="{{ route('admin.orders.show', $t->order->order_number) }}" class="hover:underline text-brand-olive">#{{ $t->order->order_number }}</a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="py-5 px-6 tracking-wide text-brand-olive">
                                        {{ $t->description }}
                                    </td>
                                    <td class="py-5 px-8 text-right font-black text-[12px] {{ $t->points > 0 ? 'text-brand-primary' : 'text-red-600' }}">
                                        {{ $t->points > 0 ? '+' : '' }}{{ number_format($t->points) }} PTS
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-16 text-center text-brand-olive uppercase tracking-widest text-[10px]">Belum ada mutasi poin loyalty.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($transactions->hasPages())
                    <div class="px-8 py-5 border-t border-brand-light bg-brand-light/10">
                        {{ $transactions->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
