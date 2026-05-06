<section id="how-to-buy-section" class="py-24 md:py-32 scroll-mt-20 relative overflow-hidden" style="background: #FFFFFF;">
    <style>
        .step-card {
            background: #FFFFFF;
            border: 1px solid #E9E9E9;
            border-radius: 40px;
            padding: 40px;
            transition: all 0.5s cubic-bezier(0.22, 1, 0.36, 1);
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 100%;
        }
        .step-card:hover {
            box-shadow: 0 30px 60px rgba(47,53,38,.06);
            transform: translateY(-8px);
            border-color: #6B705C;
        }
        .step-number {
            font-size: 64px;
            font-weight: 200;
            line-height: 1;
            color: rgba(47,53,38,.05);
            transition: all 0.5s cubic-bezier(0.22, 1, 0.36, 1);
        }
        .step-card:hover .step-number {
            color: rgba(47,53,38,.15);
            transform: translateY(-4px);
        }
        .step-dot {
            width: 12px; height: 12px;
            border-radius: 50%;
            background: rgba(47,53,38,.1);
            transition: all 0.5s cubic-bezier(0.22, 1, 0.36, 1);
        }
        .step-card:hover .step-dot {
            background: #2F3526;
            transform: scale(1.2);
        }
        .step-line {
            position: absolute;
            bottom: 40px; left: 40px;
            height: 1px; width: 0;
            background: #2F3526;
            transition: width 0.5s cubic-bezier(0.22, 1, 0.36, 1);
        }
        .step-card:hover .step-line {
            width: 40px;
        }
    </style>

    {{-- Subtle decorative background --}}
    <div class="absolute bottom-0 left-0 w-[600px] h-[600px] bg-[#F9F9F8] rounded-full blur-3xl opacity-60 -z-10 -translate-x-1/3 translate-y-1/3"></div>

    <div class="max-w-[1400px] mx-auto px-6 md:px-12 lg:px-20 relative z-10">
        {{-- Header --}}
        <div class="text-center mb-20 md:mb-28">
            <p class="text-[9px] md:text-[10px] font-black uppercase tracking-[.4em] mb-4" style="color: #6B705C;">Shopping Guide</p>
            <h2 class="text-4xl md:text-5xl lg:text-6xl font-light uppercase tracking-[.1em]" style="color: #2F3526;">
                How To <strong class="font-black" style="color: #000000;">Purchase</strong>
            </h2>
            <div class="mx-auto mt-6" style="width: 40px; height: 1.5px; background: #2F3526;"></div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 lg:gap-10">
            @php
                $steps = [
                    ['01', 'Browse', 'Temukan koleksi yang sesuai dengan karakter Anda.'],
                    ['02', 'Secure', 'Lengkapi detail pengiriman untuk presisi kurir.'],
                    ['03', 'Payment', 'Transaksi aman melalui gerbang pembayaran terenkripsi.'],
                    ['04', 'Receive', 'Duduk manis, kami akan mengantar paket Anda ke tujuan.']
                ];
            @endphp

            @foreach($steps as $step)
            <div class="step-card group cursor-default">
                {{-- Top Section --}}
                <div class="flex justify-between items-start mb-24 relative z-10">
                    <div class="step-dot mt-2"></div>
                    <span class="step-number">{{ $step[0] }}</span>
                </div>
                
                {{-- Bottom Section --}}
                <div class="relative z-10">
                    <h4 class="text-[14px] font-black uppercase tracking-[.2em] mb-4" style="color: #2F3526;">
                        {{ $step[1] }}
                    </h4>
                    <p class="text-[13px] leading-relaxed" style="color: #6B705C;">
                        {{ $step[2] }}
                    </p>
                </div>
                
                {{-- Hover Progress Line --}}
                <div class="step-line"></div>
            </div>
            @endforeach
        </div>
    </div>
</section>