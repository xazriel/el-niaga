<section id="shipping-section" class="py-24 md:py-32 scroll-mt-20 relative overflow-hidden" style="background: #FFFFFF;">
    <style>
        .shipping-card {
            background: #FFFFFF;
            border: 1px solid #E9E9E9;
            border-radius: 40px;
            padding: 40px;
            transition: all 0.5s cubic-bezier(0.22, 1, 0.36, 1);
        }
        @media (min-width: 768px) {
            .shipping-card { padding: 56px; }
        }
        .shipping-card:hover {
            box-shadow: 0 30px 60px rgba(47,53,38,.06);
            transform: translateY(-4px);
            border-color: #6B705C;
        }
        .shipping-icon {
            width: 56px; height: 56px;
            border-radius: 20px;
            display: flex; align-items: center; justify-content: center;
            background: #2F3526;
            color: #FFFFFF;
            transition: all 0.5s cubic-bezier(0.22, 1, 0.36, 1);
        }
        .shipping-card:hover .shipping-icon {
            transform: scale(1.1) rotate(-5deg);
            box-shadow: 0 15px 30px rgba(47,53,38,.2);
        }
    </style>

    {{-- Subtle decorative background --}}
    <div class="absolute top-0 left-0 w-[500px] h-[500px] bg-[#F9F9F8] rounded-full blur-3xl opacity-60 -z-10 -translate-x-1/3 -translate-y-1/3"></div>

    <div class="max-w-[1200px] mx-auto px-6 md:px-12 lg:px-20 relative z-10">
        {{-- Header --}}
        <div class="text-center mb-20 md:mb-28">
            <p class="text-[9px] md:text-[10px] font-black uppercase tracking-[.4em] mb-4" style="color: #6B705C;">Logistics & Care</p>
            <h2 class="text-4xl md:text-5xl lg:text-6xl font-light uppercase tracking-[.1em]" style="color: #2F3526;">
                Shipping & <strong class="font-black" style="color: #000000;">Returns</strong>
            </h2>
            <div class="mx-auto mt-6" style="width: 40px; height: 1.5px; background: #2F3526;"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-10 md:gap-16">
            {{-- Card 1: Pengiriman --}}
            <div class="shipping-card group cursor-default">
                <div class="shipping-icon mb-10">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0a2 2 0 012 2v2a2 2 0 01-2 2H4a2 2 0 01-2-2v-2a2 2 0 012-2m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-black mb-6 uppercase tracking-[.1em]" style="color: #2F3526;">Layanan<br>Pengiriman</h3>
                <p class="text-[13px] leading-relaxed mb-10" style="color: #6B705C;">
                    Setiap helai pakaian dikemas dengan penuh perhatian. Kami bermitra dengan kurir premium untuk menjamin integritas paket Anda.
                </p>
                <ul class="space-y-4">
                    <li class="flex items-center gap-4 text-[9px] font-black uppercase tracking-[.25em]" style="color: #000000;">
                        <span class="w-1.5 h-1.5 rounded-full" style="background: #2F3526;"></span>
                        Dispatch jam 17:00 WIB
                    </li>
                    <li class="flex items-center gap-4 text-[9px] font-black uppercase tracking-[.25em]" style="color: #000000;">
                        <span class="w-1.5 h-1.5 rounded-full" style="background: #2F3526;"></span>
                        Update Resi Maksimal H+1
                    </li>
                </ul>
            </div>

            {{-- Card 2: Retur --}}
            <div class="shipping-card group cursor-default">
                <div class="shipping-icon mb-10">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-black mb-6 uppercase tracking-[.1em]" style="color: #2F3526;">Garansi &<br>Retur</h3>
                <p class="text-[13px] leading-relaxed mb-10" style="color: #6B705C;">
                    Kepuasan Anda adalah esensi kami. Jika terdapat ketidaksesuaian, sistem retur kami dirancang untuk memudahkan Anda.
                </p>
                <ul class="space-y-4">
                    <li class="flex items-center gap-4 text-[9px] font-black uppercase tracking-[.25em]" style="color: #000000;">
                        <span class="w-1.5 h-1.5 rounded-full" style="background: #2F3526;"></span>
                        Wajib Video Unboxing
                    </li>
                    <li class="flex items-center gap-4 text-[9px] font-black uppercase tracking-[.25em]" style="color: #000000;">
                        <span class="w-1.5 h-1.5 rounded-full" style="background: #2F3526;"></span>
                        Batas Penukaran 3 Hari
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>