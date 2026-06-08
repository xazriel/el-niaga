<x-app-layout>
    <style>
        [x-cloak] { display: none !important; }

        * { 
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; 
            -webkit-font-smoothing: antialiased;
        }

        :root {
            --primary:    #1E1E24;
            --white:      #FFFFFF;
            --black:      #000000;
            --olive-tint: #9A8C73;
            --light-gray: #F4F3EF;
            --p8:  rgba(30,30,36,.05);
            --p15: rgba(30,30,36,.12);
        }

        body { background-color: var(--white); color: var(--black); }

        .custom-scrollbar::-webkit-scrollbar       { width: 2px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: var(--olive-tint); border-radius: 99px; }

        .tab-btn {
            position: relative;
            display: flex; 
            align-items: center;
            justify-content: flex-start;
            width: 220px;
            padding: 12px 24px;
            border-radius: 99px;
            font-size: 10px; 
            font-weight: 700;
            letter-spacing: .15em; 
            text-transform: uppercase;
            transition: all .3s ease;
            cursor: pointer;
            border: 1px solid transparent;
        }

        .tab-btn svg {
            margin-right: 12px;
            flex-shrink: 0;
        }

        .tab-btn.active { 
            background: var(--primary); 
            color: var(--white); 
        }

        .tab-btn:not(.active) { 
            background: transparent; 
            color: var(--olive-tint); 
            opacity: 0.6; 
        }

        .tab-btn:not(.active):hover { 
            background: var(--p8); 
            color: var(--primary); 
            opacity: 1; 
        }

        .order-card {
            border: 1px solid var(--light-gray);
            border-radius: 28px;
            background: var(--white);
            padding: 32px;
            transition: all .4s cubic-bezier(0.22, 1, 0.36, 1);
        }
        .order-card:hover {
            border-color: transparent;
            box-shadow: 0 20px 40px rgba(47,53,38,.06);
            transform: translateY(-2px);
        }

        .address-card {
            border-radius: 32px;
            background: var(--white);
            transition: all .4s cubic-bezier(0.22, 1, 0.36, 1);
        }
        .address-card:hover {
            box-shadow: 0 24px 48px rgba(47,53,38,.08);
            transform: translateY(-4px);
        }

        .badge {
            display: inline-flex; align-items: center;
            padding: 5px 12px; border-radius: 99px;
            font-size: 8px; font-weight: 700;
            letter-spacing: .12em; text-transform: uppercase;
        }

        .btn-primary {
            background: var(--primary);
            color: var(--white);
            border-radius: 99px;
            transition: all .3s ease;
            display: inline-flex; align-items: center; justify-content: center;
        }
        .btn-primary:hover { opacity: 0.9; transform: scale(1.02); }

        .modal-backdrop {
            background: transparent;
        }

        /* Tracking modal premium styles */
        .track-status-badge {
            display: inline-flex; align-items: center;
            padding: 6px 16px; border-radius: 99px;
            font-size: 9px; font-weight: 800;
            letter-spacing: .15em; text-transform: uppercase;
        }
        .track-status-badge.delivered { background:#dcfce7; color:#15803d; }
        .track-status-badge.on-process { background:#1c1c1c; color:#fff; }

        .track-ping {
            width: 8px; height: 8px; border-radius: 50%;
            display: inline-block; margin-right: 6px;
        }
        .track-ping.ping { background: #facc15; animation: ping .9s cubic-bezier(0,0,.2,1) infinite; }
        .track-ping.solid { background: #22c55e; }
        @keyframes ping {
            0%,100%{opacity:1;transform:scale(1)}
            50%{opacity:.6;transform:scale(1.3)}
        }

        .track-info-grid {
            display: grid; grid-template-columns: 1fr 1fr; gap: 24px;
            padding: 24px 0; border-top: 1px solid #F3F4F6;
        }
        .track-info-label { font-size: 9px; font-weight:700; letter-spacing:.15em; text-transform:uppercase; color:#9ca3af; margin-bottom:4px; }
        .track-info-val   { font-size: 14px; font-weight:700; color:#111; }
        .track-info-sub   { font-size: 11px; color:#6b7280; margin-top:2px; }

        .track-timeline-wrap { position: relative; padding-left: 28px; }
        .track-timeline-line {
            position: absolute; left: 8px; top: 6px; bottom: 6px;
            width: 2px;
            background: linear-gradient(to bottom, #1c1c1c, #e5e7eb, #f3f4f6);
        }
        .track-dot-wrap  { position: absolute; left: -20px; top: 2px; }
        .track-dot-active {
            width: 16px; height: 16px; border-radius: 50%;
            background: #1c1c1c; border: 3px solid #d1d5db;
            display:flex;align-items:center;justify-content:center;
        }
        .track-dot-idle {
            width: 10px; height: 10px; border-radius: 50%;
            background: #d1d5db; margin: 3px;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(24px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .fade-up { animation: fadeUp 0.8s cubic-bezier(0.22, 1, 0.36, 1) both; }
        .fade-up-1 { animation-delay: 0.1s; }
        .fade-up-2 { animation-delay: 0.2s; }

        .spinner {
            width: 24px; height: 24px;
            border: 2px solid var(--light-gray);
            border-top-color: var(--primary);
            border-radius: 50%;
            animation: spin .8s linear infinite;
        }
        @keyframes spin { to { transform: rotate(360deg); } }
    </style>

    {{-- ── WRAPPER dengan x-data di sini, BUKAN di dalam div ── --}}
    <div class="min-h-screen" style="background: var(--white);" x-data="trackingSystem()">

        {{-- ── KONTEN UTAMA ── --}}
        <div class="max-w-6xl mx-auto px-8 py-24">

            {{-- ── HEADER ── --}}
            <div class="fade-up flex flex-col md:flex-row justify-between items-start md:items-end mb-20">
                <div class="space-y-6">
                    <nav>
                        <ol class="flex items-center gap-3 text-[10px] uppercase tracking-[.3em]" style="color: var(--olive-tint);">
                            <li><a href="{{ route('home') }}" class="hover:text-black transition-colors">Home</a></li>
                            <li class="opacity-30">/</li>
                            <li style="color: var(--primary); font-weight: 700;">Account</li>
                        </ol>
                    </nav>
                    <h1 class="text-4xl md:text-4xl font-light tracking-tight" style="color: var(--primary);">
                        Hello, <span class="font-light text-black">{{ explode(' ', auth()->user()->name)[0] }}</span>
                    </h1>
                </div>
            </div>

            {{-- ── ALERTS ── --}}
            @if(session('success') || session('status'))
            <div x-data="{ show: true }" x-show="show" x-transition
                 class="fade-up fade-up-1 mb-12 flex justify-between items-center rounded-2xl px-8 py-5 text-[10px] uppercase tracking-widest font-bold"
                 style="background: var(--primary); color: var(--white);">
                <span>{{ session('success') ?? session('status') }}</span>
                <button @click="show = false" class="text-lg opacity-60 hover:opacity-100">&times;</button>
            </div>
            @endif

            <div class="flex flex-col lg:flex-row gap-20 fade-up fade-up-2">

                {{-- ── SIDEBAR ── --}}
                <div class="lg:w-1/4">
                    <div class="sticky top-12 space-y-6">
                        <p class="text-[9px] uppercase tracking-[.4em] font-black mb-6 opacity-30 px-5">Menu Navigation</p>
                        <div class="space-y-3">
                            <button @click="tab = 'orders'" :class="tab === 'orders' ? 'active' : ''" class="tab-btn">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                </svg>
                                Order History
                            </button>
                            <button @click="tab = 'loyalty'" :class="tab === 'loyalty' ? 'active' : ''" class="tab-btn">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Loyalty Points
                            </button>
                            <button @click="tab = 'delivery'" :class="tab === 'delivery' ? 'active' : ''" class="tab-btn">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                Addresses
                            </button>
                            <a href="{{ route('profile.edit') }}" class="tab-btn">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                Edit Profile
                            </a>
                        </div>
                    </div>
                </div>

                {{-- ── MAIN CONTENT ── --}}
                <div class="lg:w-3/4">

                    {{-- TAB: ORDERS --}}
                    <div x-show="tab === 'orders'"
                         x-transition:enter="transition ease-out duration-500"
                         x-transition:enter-start="opacity-0 translate-y-4">
                        <div class="mb-10 flex items-center justify-between">
                            <h4 class="text-[11px] font-black uppercase tracking-[.4em]">Recent Transactions</h4>
                            <div class="h-px flex-1 mx-8 bg-gray-100"></div>
                            <span class="text-[10px] font-bold px-4 py-1 rounded-full bg-gray-50">{{ $orders->count() }} Orders</span>
                        </div>

                        @if($orders->isEmpty())
                        <div class="py-32 text-center rounded-[3rem] border border-dashed border-gray-200">
                            <p class="text-[11px] uppercase tracking-widest text-gray-400 mb-8">Your closet is empty</p>
                            <a href="{{ route('home') }}" class="btn-primary px-10 py-4 text-[10px] font-bold uppercase tracking-widest">Explore Collection</a>
                        </div>
                        @else
                        <div class="space-y-6">
                            @foreach($orders as $order)
                            <div class="order-card">
                                <div class="flex flex-col md:flex-row justify-between items-start gap-6">
                                    <div class="space-y-4">
                                        <div class="flex items-center gap-4">
                                            <span class="text-[12px] font-black uppercase tracking-tighter">#{{ $order->order_number }}</span>
                                            <span class="h-4 w-px bg-gray-200"></span>
                                            <span class="text-[10px] uppercase tracking-widest text-gray-400">{{ $order->created_at->format('d M Y') }}</span>
                                        </div>
                                        <div>
                                            <p class="text-xl font-medium tracking-tight">Rp {{ number_format($order->grand_total, 0, ',', '.') }}</p>
                                        </div>
                                        <div class="flex items-center gap-3">
                                            @php
                                                $statusStyles = [
                                                    'pending'   => 'background:#FFFBEB; color:#B45309;',
                                                    'success'   => 'background:#F0FDF4; color:#15803D;',
                                                    'cancelled' => 'background:#FEF2F2; color:#B91C1C;',
                                                    'shipped'   => 'background:#EFF6FF; color:#1D4ED8;',
                                                ];
                                                $s = $statusStyles[$order->status] ?? 'background:var(--light-gray); color:var(--olive-tint);';
                                            @endphp
                                            <span class="badge" style="{{ $s }}">{{ $order->status }}</span>
                                            @if($order->tracking_number)
                                                <span class="text-[9px] font-mono text-gray-400">AWB: {{ $order->tracking_number }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
                                        @if($order->tracking_number)
                                        <button @click="openTrackingModal('{{ $order->tracking_number }}')"
                                                class="px-8 py-4 rounded-full border border-gray-200 text-[9px] font-bold uppercase tracking-widest hover:bg-black hover:text-white transition-all">
                                            Track Order
                                        </button>
                                        @endif
                                        <a href="{{ route('profile.orders.detail', $order->order_number) }}"
                                           class="btn-primary px-8 py-4 text-[9px] font-bold uppercase tracking-widest">
                                            Details
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @endif
                    </div>

                    {{-- TAB: ADDRESS --}}
                    <div x-show="tab === 'delivery'"
                         style="display:none"
                         x-transition:enter="transition ease-out duration-500"
                         x-transition:enter-start="opacity-0 translate-y-4">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6 mb-12">
                            <h4 class="text-[11px] font-black uppercase tracking-[.4em]">Shipping Directory</h4>
                            <a href="{{ route('address.create') }}" class="btn-primary px-8 py-4 text-[10px] font-bold uppercase tracking-widest gap-2">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                                </svg>
                                New Address
                            </a>
                        </div>

                        @php $addresses = auth()->user()->addresses ?? collect(); @endphp

                        <div class="space-y-8">
                            @forelse($addresses as $address)
                            <div class="address-card relative p-10 border border-gray-100"
                                 style="{{ $address->is_default ? 'border-color: var(--primary); border-width: 1.5px;' : '' }}">
                                @if($address->is_default)
                                <div class="absolute -top-3 left-10 rounded-full px-4 py-1 text-[8px] font-black uppercase tracking-widest"
                                     style="background: var(--primary); color: var(--white);">Primary</div>
                                @endif
                                <div class="grid md:grid-cols-2 gap-12">
                                    <div class="space-y-4">
                                        <span class="inline-block text-[9px] font-bold uppercase tracking-widest px-3 py-1 bg-gray-50 rounded">{{ $address->label }}</span>
                                        <h5 class="text-lg font-bold">{{ $address->recipient_name }}</h5>
                                        <p class="text-[11px] text-gray-500 tracking-widest">{{ $address->phone }}</p>
                                    </div>
                                    <div class="space-y-2 text-[12px] leading-relaxed opacity-80">
                                        <p class="font-medium text-black">{{ $address->address }}</p>
                                        <p>{{ $address->district_name }}, {{ $address->city_name }}</p>
                                        <p>{{ $address->province_name }} — {{ $address->postal_code }}</p>
                                    </div>
                                </div>
                                <div class="mt-10 pt-8 border-t border-gray-50 flex items-center justify-between">
                                    <div class="flex gap-8">
                                        <a href="{{ route('address.edit', $address->id) }}"
                                           class="text-[9px] font-bold uppercase tracking-widest hover:text-black transition-colors">Edit</a>
                                        <form action="{{ route('address.destroy', $address->id) }}" method="POST"
                                              onsubmit="return confirm('Remove address?')">
                                            @csrf @method('DELETE')
                                            <button class="text-[9px] font-bold uppercase tracking-widest text-red-500 hover:text-red-700">Remove</button>
                                        </form>
                                    </div>
                                    @if(!$address->is_default)
                                    <form action="{{ route('address.select', $address->id) }}" method="POST">
                                        @csrf
                                        <button class="text-[9px] font-bold uppercase tracking-widest border-b border-black pb-1">Set Default</button>
                                    </form>
                                    @endif
                                </div>
                            </div>
                            @empty
                            <div class="py-32 text-center rounded-[3rem] border border-dashed border-gray-200">
                                <p class="text-[11px] uppercase tracking-widest text-gray-400 mb-4">No addresses saved</p>
                            </div>
                            @endforelse
                        </div>
                    </div>

                    {{-- TAB: LOYALTY --}}
                    <div x-show="tab === 'loyalty'"
                         style="display:none"
                         x-transition:enter="transition ease-out duration-500"
                         x-transition:enter-start="opacity-0 translate-y-4">
                        
                        <div class="mb-12">
                            <h4 class="text-[11px] font-black uppercase tracking-[.4em] mb-2">Loyalty Points Program</h4>
                            <p class="text-[11px] text-gray-500 tracking-wider">Kumpulkan poin dari setiap pembelanjaan Anda dan tukarkan dengan diskon atau voucher eksklusif.</p>
                        </div>

                        {{-- Points card --}}
                        <div class="rounded-[2rem] p-10 mb-12 flex flex-col md:flex-row justify-between items-start md:items-center gap-8 shadow-sm" 
                             style="background: linear-gradient(135deg, #2F3526 0%, #464F39 100%); color: var(--white);">
                            <div class="space-y-4">
                                <span class="text-[9px] font-black uppercase tracking-[0.3em] opacity-75">Saldo Poin Anda</span>
                                <div class="flex items-baseline gap-2">
                                    <span class="text-6xl font-light tracking-tight">{{ auth()->user()->points ?? 0 }}</span>
                                    <span class="text-sm font-bold uppercase tracking-widest">Poin</span>
                                </div>
                                <p class="text-[10px] opacity-75 tracking-wider">Nilai tukar: 1 Poin = Rp 1.000 diskon checkout</p>
                            </div>
                            <div class="border-t md:border-t-0 md:border-l border-white/10 pt-6 md:pt-0 md:pl-10 space-y-2 text-[10px] tracking-wider opacity-90 max-w-sm">
                                <p class="font-bold uppercase tracking-widest text-xs mb-2 text-white">Cara Mendapatkan & Menggunakan Poin:</p>
                                <p>🛒 <strong>Belanja & Dapatkan</strong>: Dapatkan 10 Poin setiap pembelanjaan Rp 100.000 (berlaku kelipatan).</p>
                                <p>💰 <strong>Potongan Langsung</strong>: Tukarkan poin secara langsung saat checkout untuk memotong total transaksi.</p>
                                <p>🎫 <strong>Voucher Belanja</strong>: Tukarkan poin dengan kode voucher diskon khusus di katalog bawah ini.</p>
                            </div>
                        </div>

                        {{-- Tabs inside Loyalty --}}
                        <div x-data="{ loyaltySubTab: 'vouchers' }" class="space-y-8">
                            <div class="flex gap-8 border-b border-gray-100 pb-4">
                                <button @click="loyaltySubTab = 'vouchers'" 
                                        :class="loyaltySubTab === 'vouchers' ? 'text-black border-b border-black font-bold' : 'text-gray-400 font-medium hover:text-black'"
                                        class="text-[10px] uppercase tracking-widest pb-2 transition-colors">
                                    Katalog Voucher Poin
                                </button>
                                <button @click="loyaltySubTab = 'history'" 
                                        :class="loyaltySubTab === 'history' ? 'text-black border-b border-black font-bold' : 'text-gray-400 font-medium hover:text-black'"
                                        class="text-[10px] uppercase tracking-widest pb-2 transition-colors">
                                    Riwayat Poin
                                </button>
                            </div>

                            {{-- Subtab: Vouchers Catalog --}}
                            <div x-show="loyaltySubTab === 'vouchers'" class="space-y-6">
                                <div class="grid md:grid-cols-2 gap-8">
                                    @php
                                        $pointVouchers = $vouchersAvailable->where('points_cost', '>', 0);
                                    @endphp
                                    @forelse($pointVouchers as $voucher)
                                        <div class="rounded-3xl border border-gray-150 p-8 flex flex-col justify-between gap-6 hover:shadow-md transition-shadow relative overflow-hidden bg-white">
                                            <div class="absolute top-1/2 -left-3 w-6 h-6 rounded-full bg-white border border-gray-150 -translate-y-1/2"></div>
                                            <div class="absolute top-1/2 -right-3 w-6 h-6 rounded-full bg-white border border-gray-150 -translate-y-1/2"></div>
                                            
                                            <div class="space-y-4 pl-4 pr-4">
                                                <div class="flex justify-between items-start">
                                                    <span class="inline-block text-[8px] font-black uppercase tracking-widest px-3 py-1 bg-[#6B705C]/10 text-[#2F3526] rounded-full">
                                                        Voucher Poin
                                                    </span>
                                                    <span class="text-xs font-mono font-bold tracking-widest text-[#2F3526]">
                                                        {{ $voucher->code }}
                                                    </span>
                                                </div>
                                                
                                                <div class="space-y-1">
                                                    <h5 class="text-xl font-bold tracking-tight">
                                                        @if($voucher->type === 'percent')
                                                            Diskon {{ number_format($voucher->value, 0) }}%
                                                        @else
                                                            Potongan Rp {{ number_format($voucher->value, 0, ',', '.') }}
                                                        @endif
                                                    </h5>
                                                    <p class="text-[10px] text-gray-500 tracking-wider">
                                                        Minimal belanja Rp {{ number_format($voucher->min_spend, 0, ',', '.') }}
                                                    </p>
                                                    @if($voucher->expires_at)
                                                        <p class="text-[9px] text-red-500 font-medium tracking-wide">
                                                            Berlaku s/d {{ $voucher->expires_at->format('d M Y') }}
                                                        </p>
                                                    @endif
                                                </div>
                                            </div>
                                            
                                            <div class="border-t border-dashed border-gray-100 pt-6 flex items-center justify-between pl-4 pr-4">
                                                <div class="flex items-center gap-1">
                                                    <svg class="w-3.5 h-3.5 text-amber-500" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                    </svg>
                                                    <span class="text-[11px] font-black tracking-widest uppercase text-[#2F3526]">{{ $voucher->points_cost }} Poin</span>
                                                </div>
                                                
                                                @if(auth()->user()->points >= $voucher->points_cost)
                                                    <form action="{{ route('profile.redeem-voucher', $voucher->id) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" 
                                                                class="btn-primary px-8 py-3 rounded-full text-[9px] font-bold uppercase tracking-widest hover:scale-105 transition-transform">
                                                            Tukar Poin
                                                        </button>
                                                    </form>
                                                @else
                                                    <button disabled 
                                                            class="bg-gray-100 text-gray-400 cursor-not-allowed px-8 py-3 rounded-full text-[9px] font-bold uppercase tracking-widest">
                                                        Poin Kurang
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                    @empty
                                        <div class="col-span-2 py-16 text-center border border-dashed border-gray-200 rounded-3xl">
                                            <p class="text-[11px] uppercase tracking-widest text-gray-400">Tidak ada voucher poin yang tersedia saat ini.</p>
                                        </div>
                                    @endforelse
                                </div>
                            </div>

                            {{-- Subtab: Points History --}}
                            <div x-show="loyaltySubTab === 'history'" style="display:none" class="space-y-6">
                                <div class="overflow-x-auto rounded-3xl border border-gray-100 bg-white">
                                    <table class="w-full text-left border-collapse">
                                        <thead>
                                            <tr class="bg-gray-50 border-b border-gray-100">
                                                <th class="px-8 py-4 text-[9px] uppercase tracking-widest font-black text-gray-400">Tanggal</th>
                                                <th class="px-8 py-4 text-[9px] uppercase tracking-widest font-black text-gray-400">Tipe</th>
                                                <th class="px-8 py-4 text-[9px] uppercase tracking-widest font-black text-gray-400">Keterangan</th>
                                                <th class="px-8 py-4 text-[9px] uppercase tracking-widest font-black text-gray-400 text-right">Poin</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-50">
                                            @forelse($loyaltyTransactions as $transaction)
                                                <tr class="hover:bg-gray-50/50 transition-colors">
                                                    <td class="px-8 py-5 text-[11px] text-gray-500 font-medium tracking-wide">
                                                        {{ $transaction->created_at->format('d M Y, H:i') }}
                                                    </td>
                                                    <td class="px-8 py-5">
                                                        @php
                                                            $badgeStyle = 'background: #f3f4f6; color: #374151;';
                                                            if ($transaction->type === 'earn') {
                                                                $badgeStyle = 'background: #dcfce7; color: #15803d;';
                                                            } elseif ($transaction->type === 'redeem') {
                                                                $badgeStyle = 'background: #fee2e2; color: #b91c1c;';
                                                            } elseif ($transaction->type === 'refund') {
                                                                $badgeStyle = 'background: #dbeafe; color: #1d4ed8;';
                                                            }
                                                        @endphp
                                                        <span class="badge" style="{{ $badgeStyle }}">{{ $transaction->type }}</span>
                                                    </td>
                                                    <td class="px-8 py-5 text-[12px] font-medium text-black">
                                                        {{ $transaction->description }}
                                                        @if($transaction->order)
                                                            <a href="{{ route('profile.orders.detail', $transaction->order->order_number) }}" 
                                                               class="text-[9px] text-[#2F3526] font-bold underline ml-1 uppercase tracking-widest">
                                                                Lihat Pesanan
                                                            </a>
                                                        @endif
                                                    </td>
                                                    <td class="px-8 py-5 text-[12px] font-bold text-right">
                                                        @if($transaction->points > 0)
                                                            <span class="text-green-600">+{{ $transaction->points }}</span>
                                                        @else
                                                            <span class="text-red-600">{{ $transaction->points }}</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="4" class="px-8 py-16 text-center text-[11px] uppercase tracking-widest text-gray-400">
                                                        Belum ada riwayat transaksi poin.
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>{{-- end main content --}}
            </div>{{-- end flex row --}}
        </div>{{-- end max-w-6xl --}}

        {{-- ── TRACKING MODAL — di luar max-w container agar fixed bisa full screen ── --}}
        <div x-show="modalOpen"
             x-cloak
             class="modal-backdrop fixed inset-0 z-[9999] flex items-end sm:items-center justify-center p-4 sm:p-6"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">

            <div @click.away="modalOpen = false"
                 class="w-full max-w-2xl bg-white rounded-[2.5rem] shadow-2xl flex flex-col"
                 style="max-height: 92vh; overflow: hidden;"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-8 scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                 x-transition:leave-end="opacity-0 translate-y-8 scale-95">

                {{-- ── Modal Header ── --}}
                <div class="px-8 py-6 border-b border-gray-100 flex justify-between items-center flex-shrink-0">
                    <div>
                        <p class="text-[9px] uppercase tracking-[.35em] font-black" style="color:var(--olive-tint);">Lacak Pengiriman</p>
                        <p class="text-[11px] mt-1 text-gray-400 uppercase tracking-widest font-mono">
                            AWB: <span class="text-black font-bold" x-text="activeAwb"></span>
                        </p>
                    </div>
                    <button @click="modalOpen = false"
                            class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-lg hover:bg-gray-200 transition-colors leading-none">
                        &times;
                    </button>
                </div>

                {{-- ── Modal Body ── --}}
                <div class="px-8 py-6 overflow-y-auto custom-scrollbar flex-1 space-y-6">

                    {{-- Loading --}}
                    <div x-show="loading" class="py-20 flex flex-col items-center gap-4">
                        <div class="spinner"></div>
                        <p class="text-[10px] uppercase tracking-[.3em] opacity-40">Menghubungi Logistik...</p>
                    </div>

                    {{-- ── Tracking Data ── --}}
                    <div x-show="!loading && trackingData" class="space-y-6">

                        {{-- Status Card --}}
                        <div class="rounded-3xl p-6" style="background:#F9F9F8;">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                <div>
                                    <p class="text-[9px] uppercase tracking-widest text-gray-400 font-bold mb-1">Status Saat Ini</p>
                                    <p class="text-base font-bold leading-snug" style="color:var(--primary);" x-text="trackingData?.status"></p>
                                    <p class="text-[11px] mt-1 text-gray-500" x-text="trackingData?.last"></p>
                                </div>
                                <div class="flex-shrink-0">
                                    <span :class="trackingData?.podStatus === 'DELIVERED'
                                        ? 'track-status-badge delivered'
                                        : 'track-status-badge on-process'">
                                        <span :class="trackingData?.podStatus === 'DELIVERED'
                                            ? 'track-ping solid'
                                            : 'track-ping ping'"></span>
                                        <span x-text="trackingData?.podStatus || 'On Process'"></span>
                                    </span>
                                </div>
                            </div>

                            {{-- Info Grid --}}
                            <div class="track-info-grid" x-show="trackingData?.shipper || trackingData?.receiver">
                                <div x-show="trackingData?.shipper">
                                    <p class="track-info-label">Pengirim</p>
                                    <p class="track-info-val" x-text="trackingData?.shipper"></p>
                                    <p class="track-info-sub" x-text="trackingData?.shipperCity"></p>
                                </div>
                                <div x-show="trackingData?.receiver">
                                    <p class="track-info-label">Penerima</p>
                                    <p class="track-info-val" x-text="trackingData?.receiver"></p>
                                    <p class="track-info-sub" x-text="trackingData?.receiverCity"></p>
                                </div>
                                <div x-show="trackingData?.service">
                                    <p class="track-info-label">Layanan</p>
                                    <p class="track-info-val">
                                        <span style="background:#f3f4f6;padding:2px 8px;border-radius:4px;font-size:11px;font-style:italic;margin-right:4px;">JNE</span>
                                        <span x-text="trackingData?.service"></span>
                                    </p>
                                </div>
                                <div x-show="trackingData?.estimate">
                                    <p class="track-info-label">Estimasi Tiba</p>
                                    <p class="track-info-val" x-text="trackingData?.estimate"></p>
                                </div>
                            </div>
                        </div>

                        {{-- Timeline History --}}
                        <div x-show="trackingData?.history?.length > 0">
                            <div class="flex items-center justify-between mb-5">
                                <p class="text-[9px] uppercase tracking-[.35em] font-black" style="color:var(--primary);">Riwayat Perjalanan</p>
                                <span class="text-[10px] text-gray-400">Diperbarui baru saja</span>
                            </div>
                            <div class="track-timeline-wrap space-y-6">
                                <div class="track-timeline-line"></div>
                                <template x-for="(h, index) in trackingData?.history" :key="index">
                                    <div class="relative flex gap-5">
                                        {{-- Dot --}}
                                        <div class="relative z-10 flex-shrink-0">
                                            <div :class="index === 0
                                                    ? 'track-dot-active'
                                                    : 'w-10 h-10 rounded-full flex items-center justify-center bg-white border-2 border-gray-100'">
                                                <template x-if="index === 0">
                                                    <svg style="width:8px;height:8px;color:white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                                </template>
                                                <template x-if="index !== 0">
                                                    <div class="track-dot-idle"></div>
                                                </template>
                                            </div>
                                        </div>
                                        {{-- Text --}}
                                        <div class="flex-1 pb-2">
                                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-1">
                                                <p class="text-[12px] font-bold leading-snug"
                                                   :class="index === 0 ? 'text-black' : 'text-gray-500'"
                                                   x-text="h.desc"></p>
                                                <span class="text-[10px] font-bold whitespace-nowrap"
                                                      :class="index === 0 ? 'text-black' : 'text-gray-400'"
                                                      x-text="h.date"></span>
                                            </div>
                                            <template x-if="index === 0">
                                                <span style="font-size:9px;font-weight:800;letter-spacing:.12em;text-transform:uppercase;background:#f5f5f4;color:#78716c;padding:2px 8px;border-radius:4px;margin-top:4px;display:inline-block;">Posisi Terakhir</span>
                                            </template>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>

                    </div>

                    {{-- Error --}}
                    <div x-show="!loading && !trackingData" class="py-16 text-center space-y-4">
                        <div style="width:64px;height:64px;background:#f9fafb;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto;">
                            <svg style="width:32px;height:32px;color:#d1d5db" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                        </div>
                        <p class="text-[11px] font-bold uppercase tracking-widest text-gray-400"
                           x-text="errorMessage || 'Data tidak ditemukan'"></p>
                    </div>

                </div>{{-- end modal body --}}

                {{-- ── Modal Footer ── --}}
                <div class="px-8 py-5 flex-shrink-0" style="border-top: 1px solid #F3F4F6;">
                    <button @click="modalOpen = false"
                            class="btn-primary w-full py-4 text-[10px] font-bold uppercase tracking-widest">
                        Tutup
                    </button>
                </div>

            </div>{{-- end modal card --}}
        </div>{{-- end modal backdrop --}}

    </div>{{-- end wrapper --}}

    <script>
    function trackingSystem() {
        return {
            tab: '{{ session('success') || session('error') ? 'loyalty' : (request('tab') ?: 'orders') }}',
            modalOpen: false,
            loading: false,
            activeAwb: '',
            trackingData: null,
            errorMessage: '',

            async openTrackingModal(awb) {
                this.activeAwb    = awb;
                this.modalOpen    = true;
                this.loading      = true;
                this.trackingData = null;
                this.errorMessage = '';

                try {
                    const res    = await fetch(`/profile/track/${awb}`);
                    const result = await res.json();

                    if (result.success) {
                        this.trackingData = {
                            status:      result.status,
                            last:        result.last       || '',
                            podStatus:   result.pod_status || '',
                            shipper:     result.shipper    || '',
                            shipperCity: result.shipper_city || '',
                            receiver:    result.receiver   || '',
                            receiverCity:result.receiver_city || '',
                            service:     result.service    || '',
                            estimate:    result.estimate   || '',
                            history:     result.history    || [],
                        };
                    } else {
                        this.errorMessage = result.message || 'Data tidak ditemukan.';
                    }
                } catch (err) {
                    this.errorMessage = 'Gagal terhubung ke sistem tracking.';
                } finally {
                    this.loading = false;
                }
            }
        };
    }
    </script>
</x-app-layout>