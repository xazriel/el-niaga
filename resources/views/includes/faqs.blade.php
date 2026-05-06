<section id="faqs-section" class="py-24 md:py-32 scroll-mt-20 relative overflow-hidden" style="background: #FFFFFF;">
    <style>
        .faq-item {
            border: 1px solid #E9E9E9;
            border-radius: 32px;
            background: #FFFFFF;
            transition: all 0.5s cubic-bezier(0.22, 1, 0.36, 1);
            overflow: hidden;
            margin-bottom: 20px;
        }
        .faq-item:hover {
            box-shadow: 0 20px 40px rgba(47,53,38,.04);
            border-color: #6B705C;
        }
        .faq-summary {
            padding: 32px 40px;
            cursor: pointer;
            list-style: none;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: background 0.3s ease;
        }
        .faq-summary::-webkit-details-marker {
            display: none;
        }
        .faq-item[open] .faq-summary {
            background: rgba(47,53,38,.02);
        }
        .faq-icon {
            width: 32px; height: 32px;
            border-radius: 50%;
            border: 1px solid #E9E9E9;
            display: flex; align-items: center; justify-content: center;
            transition: all 0.5s cubic-bezier(0.22, 1, 0.36, 1);
        }
        .faq-item[open] .faq-icon {
            transform: rotate(180deg);
            background: #2F3526;
            border-color: #2F3526;
            color: #FFFFFF;
        }
        .faq-content {
            padding: 0 40px 32px 40px;
            color: #6B705C;
            font-size: 13px;
            line-height: 2;
        }
    </style>

    {{-- Decorative background --}}
    <div class="absolute top-1/2 left-1/2 w-[800px] h-[800px] bg-[#F9F9F8] rounded-full blur-3xl opacity-50 -z-10 -translate-x-1/2 -translate-y-1/2"></div>

    <div class="max-w-[1000px] mx-auto px-6 md:px-12 relative z-10">
        {{-- Header --}}
        <div class="text-center mb-20 md:mb-28">
            <p class="text-[9px] md:text-[10px] font-black uppercase tracking-[.4em] mb-4" style="color: #6B705C;">Information</p>
            <h2 class="text-4xl md:text-5xl lg:text-6xl font-light uppercase tracking-[.1em]" style="color: #2F3526;">
                F.A.<strong class="font-black" style="color: #000000;">Q</strong>
            </h2>
            <div class="mx-auto mt-6" style="width: 40px; height: 1.5px; background: #2F3526;"></div>
        </div>
        
        <div>
            @php
                $faqs = [
                    ['Apakah stok barang selalu ready?', 'Koleksi kami diproduksi secara terbatas untuk menjaga eksklusivitas. Jika item tersedia di katalog, maka unit tersebut siap dikirim.'],
                    ['Bisa kirim ke luar negeri?', 'Saat ini layanan kami mencakup seluruh wilayah Indonesia. Ekspansi internasional sedang dalam tahap persiapan.'],
                    ['Bagaimana cara cek resi?', 'Informasi pelacakan akan dikirimkan secara otomatis ke email Anda dan tersedia di dashboard akun segera setelah paket diproses.']
                ];
            @endphp

            @foreach($faqs as $faq)
            <details class="faq-item group">
                <summary class="faq-summary">
                    <span class="font-black uppercase text-[10px] tracking-[.2em] md:text-[11px]" style="color: #2F3526;">{{ $faq[0] }}</span>
                    <div class="faq-icon flex-shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </div>
                </summary>
                <div class="faq-content">
                    {{ $faq[1] }}
                </div>
            </details>
            @endforeach
        </div>
    </div>
</section>