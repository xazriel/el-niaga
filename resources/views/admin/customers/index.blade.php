<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center font-helvetica">
            <h2 class="font-bold text-xs text-brand-primary tracking-widest uppercase">
                {{ __('Kelola Pelanggan') }}
            </h2>
            <nav class="text-[9px] uppercase tracking-widest text-brand-olive font-bold">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-brand-primary">Dashboard</a> &gt; <span>Pelanggan</span>
            </nav>
        </div>
    </x-slot>

    <div class="bg-brand-white min-h-screen py-8 px-4 sm:px-6 lg:px-8 font-helvetica rounded-[2rem]">
        <div class="max-w-7xl mx-auto">
            
            {{-- Header Title --}}
            <div class="mb-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                <div>
                    <h3 class="text-2xl font-light text-brand-black tracking-wide">Daftar Pelanggan</h3>
                    <p class="text-[10px] uppercase tracking-[0.2em] text-brand-olive mt-1">Manajemen data profil dan aktivitas loyalty CRM</p>
                </div>
            </div>

            {{-- Search Filter --}}
            <form action="{{ route('admin.customers.index') }}" method="GET" class="mb-8">
                <div class="flex flex-col sm:flex-row gap-4">
                    <div class="flex-1 relative">
                        <input type="text" name="search" value="{{ request('search') }}" 
                            placeholder="CARI PELANGGAN (NAMA, EMAIL, NO. HP)..." 
                            class="w-full bg-brand-light/40 border border-brand-light rounded-full px-6 py-3.5 text-[10px] tracking-widest placeholder-brand-olive/60 uppercase focus:outline-none focus:ring-1 focus:ring-brand-primary focus:border-brand-primary">
                    </div>
                    <button type="submit" class="bg-brand-primary text-brand-white px-8 py-3.5 rounded-full text-[10px] font-bold uppercase tracking-widest hover:bg-brand-olive transition">Cari</button>
                    @if(request('search'))
                        <a href="{{ route('admin.customers.index') }}" class="border border-brand-light text-brand-black px-6 py-3.5 rounded-full text-[10px] font-bold uppercase tracking-widest hover:bg-brand-light transition flex items-center justify-center">Reset</a>
                    @endif
                </div>
            </form>

            {{-- Table --}}
            <div class="bg-brand-white rounded-[2rem] border border-brand-light overflow-hidden shadow-sm">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-brand-light/30 border-b border-brand-light text-[9px] uppercase tracking-[0.2em] text-brand-olive font-black">
                                <th class="py-5 px-8">Nama Pelanggan</th>
                                <th class="py-5 px-6">Informasi Kontak</th>
                                <th class="py-5 px-6 text-center">Poin Loyalty</th>
                                <th class="py-5 px-6 text-center">Total Belanja</th>
                                <th class="py-5 px-6 text-center">Pemesanan</th>
                                <th class="py-5 px-6">Tanggal Daftar</th>
                                <th class="py-5 px-8 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-brand-light text-[11px] text-brand-black">
                            @forelse($customers as $customer)
                                <tr class="hover:bg-brand-light/10 transition">
                                    <td class="py-5 px-8 font-bold text-[12px]">{{ $customer->name }}</td>
                                    <td class="py-5 px-6">
                                        <div class="tracking-wide">{{ $customer->email }}</div>
                                        <div class="text-[9px] text-brand-olive uppercase tracking-widest mt-0.5">{{ $customer->phone ?? '-' }}</div>
                                    </td>
                                    <td class="py-5 px-6 text-center">
                                        <span class="inline-block bg-brand-primary text-brand-white font-bold text-[10px] px-3 py-1 rounded-full">{{ $customer->points }} PTS</span>
                                    </td>
                                    <td class="py-5 px-6 text-center font-bold">
                                        Rp {{ number_format($customer->orders_sum_grand_total ?? 0, 0, ',', '.') }}
                                    </td>
                                    <td class="py-5 px-6 text-center font-medium">
                                        {{ $customer->orders_count }} Order
                                    </td>
                                    <td class="py-5 px-6 text-brand-olive">
                                        {{ $customer->created_at->format('d M Y') }}
                                    </td>
                                    <td class="py-5 px-8 text-right">
                                        <a href="{{ route('admin.customers.show', $customer->id) }}" 
                                            class="inline-block bg-brand-light text-brand-black hover:bg-brand-primary hover:text-brand-white px-5 py-2.5 rounded-full text-[9px] font-bold uppercase tracking-widest transition-all">Detail Aktivitas</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="py-16 text-center text-brand-olive uppercase tracking-widest text-[10px]">Belum ada pelanggan terdaftar.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($customers->hasPages())
                    <div class="px-8 py-5 border-t border-brand-light bg-brand-light/10">
                        {{ $customers->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
