<x-app-layout>
    <style>
        [x-cloak] { display: none !important; }

        /* ── Typography & Base ── */
        * { 
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; 
            -webkit-font-smoothing: antialiased;
        }

        :root {
            --primary:    #2F3526;
            --white:      #FFFFFF;
            --black:      #000000;
            --olive-tint: #6B705C;
            --light-gray: #E9E9E9;
            --p8:  rgba(47,53,38,.05);
            --p15: rgba(47,53,38,.12);
        }

        body { background-color: var(--white); color: var(--black); }

        /* ── Scrollbar Refined ── */
        .custom-scrollbar::-webkit-scrollbar       { width: 2px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: var(--olive-tint); border-radius: 99px; }

        /* ── Navigation Buttons Fixed ── */
.tab-btn {
    position: relative;
    display: flex; 
    align-items: center; /* Memastikan icon & teks sejajar vertikal */
    justify-content: flex-start; /* Memulai dari kiri */
    width: 220px; /* Lebar tetap agar ukuran pill Order History & Shipping Address sama persis */
    padding: 12px 24px; /* Padding kiri-kanan lebih lega agar bentuk pill terlihat bagus */
    border-radius: 99px; /* Pill shape lebih konsisten */
    font-size: 10px; 
    font-weight: 700;
    letter-spacing: .15em; 
    text-transform: uppercase;
    transition: all .3s ease;
    cursor: pointer;
    border: 1px solid transparent; /* Mencegah layout jumping */
}

.tab-btn svg {
    margin-right: 12px; /* Jarak tetap antara icon dan teks */
    flex-shrink: 0; /* Mencegah icon gepeng */
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

        /* ── Luxury Cards ── */
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

        /* ── UI Elements ── */
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
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            background: rgba(0, 0, 0, 0.3);
        }

        /* ── Animations ── */
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

    <div class="min-h-screen" style="background: var(--white);">
        <div class="max-w-6xl mx-auto px-8 py-24" x-data="trackingSystem()" x-cloak>

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
                        Hello, <span class="font-lighr text-black">{{ explode(' ', auth()->user()->name)[0] }}</span>
                    </h1>
                </div>
            </div>

            {{-- ── ALERTS ── --}}
            @if(session('success') || session('status'))
            <div x-data="{ show: true }" x-show="show" x-transition class="fade-up fade-up-1 mb-12 flex justify-between items-center rounded-2xl px-8 py-5 text-[10px] uppercase tracking-widest font-bold" style="background: var(--primary); color: var(--white);">
                <span>{{ session('success') ?? session('status') }}</span>
                <button @click="show = false" class="text-lg opacity-60 hover:opacity-100">&times;</button>
            </div>
            @endif

            <div class="flex flex-col lg:flex-row gap-20 fade-up fade-up-2">
                {{-- ── SIDEBAR ── --}}
                <!-- Bagian Sidebar -->
<div class="lg:w-1/4">
    <div class="sticky top-12 space-y-6">
        <p class="text-[9px] uppercase tracking-[.4em] font-black mb-6 opacity-30 px-5">Menu Navigation</p>
        <div class="space-y-3">
            <button @click="tab = 'orders'" :class="tab === 'orders' ? 'active' : ''" class="tab-btn">
                <!-- Icon Box -->
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                </svg>
                Order History
            </button>

            <button @click="tab = 'delivery'" :class="tab === 'delivery' ? 'active' : ''" class="tab-btn">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                </svg>
                Shipping Address
            </button>
        </div>
    </div>
</div>

                {{-- ── MAIN CONTENT ── --}}
                <div class="lg:w-3/4">
                    {{-- TAB: ORDERS --}}
                    <div x-show="tab === 'orders'" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 translate-y-4">
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
                    <div x-show="tab === 'delivery'" style="display:none" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 translate-y-4">
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
                            <div class="address-card relative p-10 border border-gray-100" style="{{ $address->is_default ? 'border-color: var(--primary); border-width: 1.5px;' : '' }}">
                                @if($address->is_default)
                                <div class="absolute -top-3 left-10 rounded-full px-4 py-1 text-[8px] font-black uppercase tracking-widest" style="background: var(--primary); color: var(--white);">Primary</div>
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
                                        <a href="{{ route('address.edit', $address->id) }}" class="text-[9px] font-bold uppercase tracking-widest hover:text-black transition-colors">Edit</a>
                                        <form action="{{ route('address.destroy', $address->id) }}" method="POST" onsubmit="return confirm('Remove address?')">
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
                </div>
            </div>

            {{-- ── TRACKING MODAL ── --}}
            <div x-show="modalOpen" class="modal-backdrop fixed inset-0 z-[60] flex items-end sm:items-center justify-center p-4 sm:p-8" x-transition x-cloak>
                <div @click.away="modalOpen = false" class="w-full max-w-xl bg-white rounded-[2.5rem] shadow-2xl overflow-hidden flex flex-col" style="max-height: 85vh;">
                    <div class="p-10 border-b border-gray-50 flex justify-between items-center">
                        <div>
                            <h3 class="text-[12px] font-black uppercase tracking-[.4em]">Shipment Data</h3>
                            <p class="text-[10px] mt-2 text-gray-400 uppercase tracking-widest">AWB <span class="text-black font-mono" x-text="activeAwb"></span></p>
                        </div>
                        <button @click="modalOpen = false" class="w-12 h-12 rounded-full bg-gray-50 flex items-center justify-center hover:bg-gray-100 transition-colors">&times;</button>
                    </div>

                    <div class="p-10 overflow-y-auto custom-scrollbar flex-1">
                        <div x-show="loading" class="py-20 flex flex-col items-center">
                            <div class="spinner mb-6"></div>
                            <p class="text-[10px] uppercase tracking-[.3em] opacity-40">Contacting Logistics...</p>
                        </div>

                        <div x-show="!loading && trackingData">
                            <div class="mb-12 p-8 rounded-3xl bg-[#F9F9F8]">
                                <p class="text-[8px] uppercase tracking-widest text-gray-400 mb-2">Current Status</p>
                                <p class="text-lg font-bold uppercase tracking-tight text-[#2F3526]" x-text="trackingData?.status"></p>
                                <p class="text-[11px] mt-2 opacity-60" x-text="trackingData?.last"></p>
                            </div>

                            <div class="relative pl-10 space-y-10">
                                <div class="absolute left-[3px] top-2 bottom-2 w-[1px] bg-gray-100"></div>
                                <template x-for="(h, index) in trackingData?.history" :key="index">
                                    <div class="relative">
                                        <div :class="index === 0 ? 'bg-black w-2 h-2 scale-150' : 'bg-gray-200 w-1.5 h-1.5'" class="absolute -left-[10px] top-1 rounded-full z-10 transition-all"></div>
                                        <div>
                                            <p class="text-[9px] font-bold uppercase tracking-widest mb-1" :class="index === 0 ? 'text-black' : 'text-gray-400'" x-text="h.date"></p>
                                            <p class="text-[11px] leading-relaxed opacity-70" x-text="h.desc"></p>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <div x-show="!loading && !trackingData" class="py-12 text-center">
                            <p class="text-[10px] font-bold uppercase tracking-widest text-red-400" x-text="errorMessage || 'Logistics ID not found'"></p>
                        </div>
                    </div>

                    <div class="p-10 pt-0">
                        <button @click="modalOpen = false" class="btn-primary w-full py-5 text-[10px] font-bold uppercase tracking-widest">Close Record</button>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
    function trackingSystem() {
        return {
            tab: 'orders',
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
                            status:  result.status,
                            last:    result.last || '',
                            history: result.history || [],
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