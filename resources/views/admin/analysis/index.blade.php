<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center font-helvetica">
            <h2 class="font-bold text-xs text-brand-primary tracking-widest uppercase">
                {{ __('Analisis Penjualan & BI') }}
            </h2>
            <div class="flex gap-2">
                <form action="{{ route('admin.analysis.index') }}" method="GET" id="chartFilterForm">
                    <select name="chart_filter" onchange="document.getElementById('chartFilterForm').submit()"
                        class="bg-brand-light text-brand-black px-4 py-2 border-none rounded-full text-[9px] font-bold uppercase tracking-widest focus:outline-none">
                        <option value="daily" {{ $filter === 'daily' ? 'selected' : '' }}>Harian (7 Hari)</option>
                        <option value="weekly" {{ $filter === 'weekly' ? 'selected' : '' }}>Mingguan (4 Minggu)</option>
                        <option value="monthly" {{ $filter === 'monthly' ? 'selected' : '' }}>Bulanan (6 Bulan)</option>
                        <option value="yearly" {{ $filter === 'yearly' ? 'selected' : '' }}>Tahunan (3 Tahun)</option>
                    </select>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="bg-brand-white min-h-screen py-8 px-4 sm:px-6 lg:px-8 font-helvetica rounded-[2rem]">
        <div class="max-w-7xl mx-auto">

            @if(session('success'))
                <div class="mb-8 p-5 rounded-2xl bg-brand-primary text-brand-white text-[10px] font-bold uppercase tracking-widest flex justify-between items-center">
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            {{-- BI Header --}}
            <div class="mb-10">
                <h3 class="text-3xl font-light text-brand-black tracking-wide">Executive Dashboard</h3>
                <p class="text-[10px] uppercase tracking-[0.2em] text-brand-olive mt-1">Laporan analitik bisnis, performa penjualan, dan loyalty CRM</p>
            </div>

            {{-- 1. Metrics Grid --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8 mb-12">
                {{-- Total Omset --}}
                <div class="bg-brand-black p-8 rounded-[2rem] text-brand-white flex flex-col justify-between min-h-[160px]">
                    <p class="text-brand-white/50 text-[9px] uppercase tracking-[0.2em]">Total Penjualan</p>
                    <h2 class="text-2xl font-bold tracking-tight mt-4">Rp {{ number_format($totalSales, 0, ',', '.') }}</h2>
                    <p class="text-brand-white/40 text-[8px] uppercase tracking-widest mt-2">Akumulasi Seluruh Pesanan Sukses</p>
                </div>
                {{-- Total Transaksi --}}
                <div class="bg-brand-light/30 p-8 rounded-[2rem] border border-brand-light flex flex-col justify-between min-h-[160px]">
                    <p class="text-brand-olive text-[9px] uppercase tracking-[0.2em]">Total Transaksi</p>
                    <h2 class="text-2xl font-bold tracking-tight mt-4 text-brand-black">{{ number_format($totalTransactions) }}</h2>
                    <p class="text-brand-olive/60 text-[8px] uppercase tracking-widest mt-2">Pesanan Selesai / Terbayar</p>
                </div>
                {{-- Total Pelanggan --}}
                <div class="bg-brand-light/30 p-8 rounded-[2rem] border border-brand-light flex flex-col justify-between min-h-[160px]">
                    <p class="text-brand-olive text-[9px] uppercase tracking-[0.2em]">Total Pelanggan</p>
                    <h2 class="text-2xl font-bold tracking-tight mt-4 text-brand-black">{{ number_format($totalCustomers) }}</h2>
                    <p class="text-brand-olive/60 text-[8px] uppercase tracking-widest mt-2">Pelanggan Terdaftar CRM</p>
                </div>
                {{-- Produk Terjual --}}
                <div class="bg-brand-light/30 p-8 rounded-[2rem] border border-brand-light flex flex-col justify-between min-h-[160px]">
                    <p class="text-brand-olive text-[9px] uppercase tracking-[0.2em]">Produk Terjual</p>
                    <h2 class="text-2xl font-bold tracking-tight mt-4 text-brand-black">{{ number_format($productsSold) }} PCS</h2>
                    <p class="text-brand-olive/60 text-[8px] uppercase tracking-widest mt-2">Volume Produk Keluar</p>
                </div>
            </div>

            {{-- 2. Performance & Growth + Chart --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-12">
                {{-- Monthly Growth rate analysis --}}
                <div class="bg-brand-light/20 p-8 rounded-[2rem] border border-brand-light flex flex-col justify-between">
                    <div>
                        <span class="inline-block bg-brand-primary text-brand-white text-[9px] font-black tracking-widest px-4 py-1.5 rounded-full mb-6">ANALISIS OMSET</span>
                        <h4 class="text-[10px] font-bold uppercase tracking-widest text-brand-olive mb-1">Pertumbuhan Bulan Ini</h4>
                        <h2 class="text-3xl font-light text-brand-black tracking-tight mt-2">
                            Rp {{ number_format($salesThisMonth, 0, ',', '.') }}
                        </h2>
                        
                        <div class="flex items-center gap-2 mt-4">
                            @if($growthRate >= 0)
                                <span class="bg-emerald-100 text-emerald-800 text-[10px] font-bold px-3 py-1 rounded-full flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg>
                                    +{{ number_format($growthRate, 1) }}%
                                </span>
                            @else
                                <span class="bg-rose-100 text-rose-800 text-[10px] font-bold px-3 py-1 rounded-full flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 14l-7 7m0 0l-7-7m7 7V3"/></svg>
                                    {{ number_format($growthRate, 1) }}%
                                </span>
                            @endif
                            <span class="text-[9px] text-brand-olive uppercase tracking-widest">vs bulan lalu</span>
                        </div>
                    </div>
                    <div class="mt-8 border-t border-brand-light pt-6">
                        <div class="flex justify-between text-[11px] text-brand-olive font-medium">
                            <span>Omset Bulan Lalu:</span>
                            <span class="font-bold text-brand-black">Rp {{ number_format($salesLastMonth, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                {{-- Chart container --}}
                <div class="lg:col-span-2 bg-brand-white p-8 rounded-[2rem] border border-brand-light shadow-sm">
                    <h4 class="text-[11px] font-black uppercase tracking-[0.2em] text-brand-primary mb-6">Tren Grafik Penjualan</h4>
                    <div class="h-[220px]">
                        <canvas id="salesChart"></canvas>
                    </div>
                </div>
            </div>

            {{-- 3. Top rankings: Bestsellers & Top Points Customers --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">
                {{-- Bestsellers ranking --}}
                <div class="bg-brand-white p-8 border border-brand-light rounded-[2rem] shadow-sm">
                    <div class="flex justify-between items-center mb-6">
                        <h4 class="text-[11px] font-black uppercase tracking-[0.2em] text-brand-primary">Ranking Produk Terlaris</h4>
                        <span class="text-[9px] uppercase tracking-widest text-brand-olive font-bold">Top 5</span>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="border-b border-brand-light text-[8px] uppercase tracking-[0.2em] text-brand-olive font-bold">
                                    <th class="pb-3 text-center w-12">Rank</th>
                                    <th class="pb-3">Produk</th>
                                    <th class="pb-3 text-center">Terjual</th>
                                    <th class="pb-3 text-right">Pendapatan</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-brand-light text-[10px]">
                                @forelse($bestSellers as $index => $bs)
                                    <tr>
                                        <td class="py-4 text-center">
                                            <span class="inline-block w-6 h-6 rounded-full bg-brand-light text-brand-black flex items-center justify-center font-bold text-[9px]">{{ $index + 1 }}</span>
                                        </td>
                                        <td class="py-4 flex items-center gap-3">
                                            @if($bs->product && $bs->product->images->first())
                                                <img src="{{ asset('storage/' . $bs->product->images->first()->image_path) }}" class="w-10 h-10 object-cover rounded-xl">
                                            @else
                                                <div class="w-10 h-10 bg-brand-light rounded-xl flex items-center justify-center text-[7px] uppercase font-bold text-brand-olive">NO IMG</div>
                                            @endif
                                            <div>
                                                <span class="font-bold text-brand-black block uppercase tracking-wide">{{ $bs->product->name ?? 'Produk Terhapus' }}</span>
                                                <span class="text-[8px] text-brand-olive uppercase tracking-widest">{{ $bs->product->category->name ?? '-' }}</span>
                                            </div>
                                        </td>
                                        <td class="py-4 text-center font-bold">{{ $bs->total_qty }} Pcs</td>
                                        <td class="py-4 text-right font-bold text-brand-primary">Rp {{ number_format($bs->revenue, 0, ',', '.') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="py-12 text-center text-brand-olive uppercase tracking-widest">Belum ada data penjualan produk.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Top Loyalty Customers --}}
                <div class="bg-brand-white p-8 border border-brand-light rounded-[2rem] shadow-sm">
                    <div class="flex justify-between items-center mb-6">
                        <h4 class="text-[11px] font-black uppercase tracking-[0.2em] text-brand-primary">Pelanggan Poin Tertinggi</h4>
                        <span class="text-[9px] uppercase tracking-widest text-brand-olive font-bold">Top 5</span>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="border-b border-brand-light text-[8px] uppercase tracking-[0.2em] text-brand-olive font-bold">
                                    <th class="pb-3 text-center w-12">Rank</th>
                                    <th class="pb-3">Nama Pelanggan</th>
                                    <th class="pb-3 text-center font-mono">Poin</th>
                                    <th class="pb-3 text-right">Tanggal Gabung</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-brand-light text-[10px]">
                                @forelse($topPointsCustomers as $index => $customer)
                                    <tr>
                                        <td class="py-4 text-center">
                                            <span class="inline-block w-6 h-6 rounded-full bg-brand-light text-brand-black flex items-center justify-center font-bold text-[9px]">{{ $index + 1 }}</span>
                                        </td>
                                        <td class="py-4">
                                            <a href="{{ route('admin.customers.show', $customer->id) }}" class="font-bold hover:underline text-brand-primary uppercase block tracking-wide">{{ $customer->name }}</a>
                                            <span class="text-[8px] text-brand-olive">{{ $customer->email }}</span>
                                        </td>
                                        <td class="py-4 text-center font-bold">
                                            <span class="inline-block bg-brand-primary text-brand-white px-3 py-1 rounded-full text-[8px] font-bold font-mono">{{ $customer->points }} PTS</span>
                                        </td>
                                        <td class="py-4 text-right text-brand-olive">{{ $customer->created_at->format('d M Y') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="py-12 text-center text-brand-olive uppercase tracking-widest">Belum ada pelanggan terdaftar.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- 4. Slow Moving / clearance actions --}}
            <div class="bg-brand-white p-8 border border-brand-light rounded-[2.5rem]">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
                    <div>
                        <h4 class="text-[11px] font-black uppercase tracking-[0.2em] text-brand-primary">Identifikasi Produk Kurang Laku (Slow-Moving)</h4>
                        <p class="text-[9px] text-brand-olive mt-1 uppercase tracking-widest">Produk berumur &gt; 30 hari dengan penjualan kurang dari 5 unit dalam 30 hari terakhir</p>
                    </div>
                    <span class="bg-red-50 text-red-700 text-[9px] font-bold px-4 py-1.5 rounded-full uppercase tracking-widest border border-red-200">Rekomendasi Cuci Gudang (Diskon 20%)</span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="border-b border-brand-light text-[8px] uppercase tracking-[0.2em] text-brand-olive font-bold">
                                <th class="pb-3 px-4">Produk</th>
                                <th class="pb-3 text-center">Tanggal Rilis</th>
                                <th class="pb-3 text-center">Penjualan 30 Hari</th>
                                <th class="pb-3 text-center">Harga Asli</th>
                                <th class="pb-3 text-center">Harga Promo</th>
                                <th class="pb-3 text-right">Aksi Diskon 20%</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-brand-light text-[10px]">
                            @forelse($slowMovingProducts as $smp)
                                <tr class="hover:bg-brand-light/10 transition">
                                    <td class="py-4 px-4 flex items-center gap-3">
                                        @if($smp->images->first())
                                            <img src="{{ asset('storage/' . $smp->images->first()->image_path) }}" class="w-10 h-10 object-cover rounded-xl">
                                        @else
                                            <div class="w-10 h-10 bg-brand-light rounded-xl flex items-center justify-center text-[7px] uppercase font-bold text-brand-olive font-bold">NO IMG</div>
                                        @endif
                                        <div>
                                            <span class="font-bold text-brand-black block uppercase tracking-wide text-[11px]">{{ $smp->name }}</span>
                                            <span class="text-[8px] text-brand-olive uppercase tracking-widest">{{ $smp->category->name ?? '-' }}</span>
                                        </div>
                                    </td>
                                    <td class="py-4 text-center text-brand-olive">
                                        {{ $smp->created_at->format('d M Y') }}
                                    </td>
                                    <td class="py-4 text-center font-bold">
                                        <span class="bg-red-50 text-red-600 px-3 py-1 rounded-full text-[9px] font-bold">{{ $smp->sold_count_recent }} terjual</span>
                                    </td>
                                    <td class="py-4 text-center text-brand-olive">
                                        Rp {{ number_format($smp->original_price ?? $smp->price, 0, ',', '.') }}
                                    </td>
                                    <td class="py-4 text-center font-bold text-brand-black">
                                        Rp {{ number_format($smp->price, 0, ',', '.') }}
                                    </td>
                                    <td class="py-4 text-right">
                                        @if($smp->custom_tag === 'Cuci Gudang')
                                            <span class="inline-block bg-brand-primary text-brand-white text-[9px] font-bold uppercase tracking-widest px-4 py-2 rounded-full">Diskon 20% Terpasang</span>
                                        @else
                                            <form action="{{ route('admin.analysis.clearance', $smp->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" 
                                                    class="inline-block bg-red-600 hover:bg-brand-primary text-brand-white text-[9px] font-bold uppercase tracking-widest px-5 py-2.5 rounded-full transition-all">Terapkan Diskon 20%</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-16 text-center text-brand-olive uppercase tracking-widest">Semua produk terjual dengan baik. Tidak ada produk slow-moving.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    {{-- ChartJS logic --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('salesChart').getContext('2d');
            
            const labels = @json($chartData['labels']);
            const salesData = @json($chartData['totals']);
            const txCounts = @json($chartData['counts']);

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Omset Penjualan (Rp)',
                            data: salesData,
                            borderColor: '#2F3526',
                            backgroundColor: 'rgba(47, 53, 38, 0.1)',
                            borderWidth: 2,
                            fill: true,
                            tension: 0.3,
                            yAxisID: 'y'
                        },
                        {
                            label: 'Volume Transaksi (Qty)',
                            data: txCounts,
                            borderColor: '#6B705C',
                            backgroundColor: 'rgba(107, 112, 92, 0.2)',
                            borderWidth: 1.5,
                            type: 'bar',
                            yAxisID: 'y1'
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            labels: {
                                font: { size: 9, family: 'Helvetica' }
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: { display: false },
                            ticks: { font: { size: 9 } }
                        },
                        y: {
                            type: 'linear',
                            display: true,
                            position: 'left',
                            grid: { color: '#f3f4f6' },
                            ticks: {
                                font: { size: 8 },
                                callback: function(value) {
                                    return 'Rp ' + (value / 1000).toLocaleString() + 'k';
                                }
                            }
                        },
                        y1: {
                            type: 'linear',
                            display: true,
                            position: 'right',
                            grid: { drawOnChartArea: false },
                            ticks: { font: { size: 8 } }
                        }
                    }
                }
            });
        });
    </script>
</x-app-layout>
