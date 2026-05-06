<section id="contact-section" class="py-24 md:py-32 scroll-mt-20 relative overflow-hidden" style="background: #FFFFFF;">
    <style>
        .contact-input {
            width: 100%;
            background: transparent;
            border-bottom: 1px solid rgba(47,53,38,.15);
            padding: 12px 0;
            font-size: 13px;
            outline: none;
            transition: all 0.4s cubic-bezier(0.22, 1, 0.36, 1);
            color: #000000;
        }
        .contact-input:focus {
            border-bottom-color: #2F3526;
        }
        .contact-input::placeholder {
            color: rgba(47,53,38,.3);
            font-weight: 400;
        }
        
        .contact-card {
            background: #FFFFFF;
            border: 1px solid #E9E9E9;
            border-radius: 40px;
            padding: 40px;
            transition: all 0.5s cubic-bezier(0.22, 1, 0.36, 1);
        }
        @media (min-width: 768px) {
            .contact-card { padding: 56px; }
        }
        .contact-card:hover {
            box-shadow: 0 30px 60px rgba(47,53,38,.06);
            transform: translateY(-4px);
            border-color: #6B705C;
        }
        
        .social-btn {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 14px 28px;
            border-radius: 99px;
            font-size: 9px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .2em;
            border: 1px solid rgba(47,53,38,.15);
            color: #6B705C;
            transition: all 0.4s cubic-bezier(0.22, 1, 0.36, 1);
        }
        .social-btn:hover {
            border-color: #2F3526;
            color: #FFFFFF;
            background: #2F3526;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(47,53,38,.15);
        }
        
        .icon-box {
            width: 48px; height: 48px;
            border-radius: 16px;
            display: flex; align-items: center; justify-content: center;
            background: rgba(47,53,38,.04);
            transition: all 0.4s cubic-bezier(0.22, 1, 0.36, 1);
        }
        .contact-item:hover .icon-box {
            background: #2F3526;
            color: #FFFFFF;
            transform: scale(1.05) rotate(-5deg);
        }
        .contact-item:hover .icon-box svg {
            stroke: #FFFFFF;
        }
    </style>

    {{-- Subtle decorative background --}}
    <div class="absolute top-0 right-0 w-[600px] h-[600px] bg-[#F9F9F8] rounded-full blur-3xl opacity-60 -z-10 translate-x-1/3 -translate-y-1/3"></div>

    <div class="max-w-[1400px] mx-auto px-6 md:px-12 lg:px-20 relative z-10">

        {{-- Header --}}
        <div class="text-center mb-20 md:mb-28">
            <p class="text-[9px] md:text-[10px] font-black uppercase tracking-[.4em] mb-4" style="color: #6B705C;">Reach Us</p>
            <h2 class="text-4xl md:text-5xl lg:text-6xl font-light uppercase tracking-[.1em]" style="color: #2F3526;">
                Get In <strong class="font-black" style="color: #000000;">Touch</strong>
            </h2>
            <div class="mx-auto mt-6" style="width: 40px; height: 1.5px; background: #2F3526;"></div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-16 lg:gap-24 items-center">

            {{-- LEFT: Info --}}
            <div class="lg:col-span-5 lg:pr-8">
                <p class="text-[9px] font-black uppercase tracking-[.3em] mb-4" style="color: #6B705C;">Contact Information</p>
                <h3 class="text-2xl md:text-3xl font-black uppercase tracking-[.1em] mb-6 leading-tight" style="color: #2F3526;">
                    Kami siap<br>membantu kamu.
                </h3>
                <p class="text-[13px] leading-relaxed mb-12" style="color: #6B705C;">
                    Punya pertanyaan seputar produk atau kolaborasi?<br class="hidden md:block">
                    Jangan ragu untuk menyapa kami kapan saja.
                </p>

                {{-- Contact items --}}
                <div class="space-y-8">
                    <div class="contact-item flex items-start gap-6 cursor-default">
                        <div class="icon-box flex-shrink-0">
                            <svg class="w-5 h-5 transition-colors duration-300" fill="none" stroke="#2F3526" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-[8px] font-black uppercase tracking-[.3em] mb-2" style="color: #6B705C;">Our Studio</p>
                            <p class="text-[13px] font-medium leading-relaxed" style="color: #000000;">
                                Jl. Raya Jakarta No. 123<br>Jakarta Selatan
                            </p>
                        </div>
                    </div>

                    <div class="contact-item flex items-start gap-6 cursor-default">
                        <div class="icon-box flex-shrink-0">
                            <svg class="w-5 h-5 transition-colors duration-300" fill="none" stroke="#2F3526" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-[8px] font-black uppercase tracking-[.3em] mb-2" style="color: #6B705C;">WhatsApp Only</p>
                            <p class="text-[13px] font-medium" style="color: #000000;">+62 812 3456 7890</p>
                        </div>
                    </div>

                    <div class="contact-item flex items-start gap-6 cursor-default">
                        <div class="icon-box flex-shrink-0">
                            <svg class="w-5 h-5 transition-colors duration-300" fill="none" stroke="#2F3526" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-[8px] font-black uppercase tracking-[.3em] mb-2" style="color: #6B705C;">Email Support</p>
                            <p class="text-[13px] font-medium" style="color: #000000;">hello@farhanaofficial.com</p>
                        </div>
                    </div>
                </div>

                {{-- Social buttons --}}
                <div class="flex flex-wrap gap-4 mt-16">
                    <a href="#" class="social-btn group">
                        <svg class="w-4 h-4 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <rect x="2" y="2" width="20" height="20" rx="5" ry="5" stroke-width="1.5"/>
                            <circle cx="12" cy="12" r="4" stroke-width="1.5"/>
                            <circle cx="17.5" cy="6.5" r="1" fill="currentColor" stroke="none"/>
                        </svg>
                        Instagram
                    </a>
                    <a href="#" class="social-btn group">
                        <svg class="w-4 h-4 transition-transform group-hover:scale-110" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M19.59 6.69a4.83 4.83 0 01-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 01-2.88 2.5 2.89 2.89 0 01-2.89-2.89 2.89 2.89 0 012.89-2.89c.28 0 .54.04.79.1V9.01a6.3 6.3 0 00-.79-.05A6.34 6.34 0 003.15 15.2a6.34 6.34 0 006.34 6.34 6.34 6.34 0 006.34-6.34V8.69a8.24 8.24 0 004.84 1.56V6.79a4.85 4.85 0 01-1.08-.1z"/>
                        </svg>
                        TikTok
                    </a>
                </div>
            </div>

            {{-- RIGHT: Form --}}
            <div class="lg:col-span-7 w-full">
                <div class="contact-card">
                    <h4 class="text-2xl font-light tracking-tight mb-2" style="color: #2F3526;">Drop a Message</h4>
                    <p class="text-[11px] uppercase tracking-widest font-bold opacity-40 mb-10">We usually reply within 24 hours.</p>

                    <form action="#" method="POST" class="space-y-8">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="relative">
                                <label class="block text-[8px] font-black uppercase tracking-[.3em] mb-1" style="color: #6B705C;">First Name</label>
                                <input type="text" name="first_name" placeholder="Farhana" class="contact-input">
                            </div>
                            <div class="relative">
                                <label class="block text-[8px] font-black uppercase tracking-[.3em] mb-1" style="color: #6B705C;">Last Name</label>
                                <input type="text" name="last_name" placeholder="Official" class="contact-input">
                            </div>
                        </div>

                        <div class="relative">
                            <label class="block text-[8px] font-black uppercase tracking-[.3em] mb-1" style="color: #6B705C;">Email Address</label>
                            <input type="email" name="email" placeholder="hello@email.com" class="contact-input">
                        </div>

                        <div class="relative">
                            <label class="block text-[8px] font-black uppercase tracking-[.3em] mb-1" style="color: #6B705C;">Your Message</label>
                            <textarea name="message" rows="3" placeholder="Tulis pesanmu di sini..." class="contact-input resize-none"></textarea>
                        </div>

                        <div class="pt-4">
                            <button type="submit" 
                                    class="w-full md:w-auto inline-flex items-center justify-center gap-3 px-12 py-5 rounded-full text-[10px] font-black uppercase tracking-[.3em] transition-all hover:-translate-y-1 hover:shadow-xl"
                                    style="background: #2F3526; color: #FFFFFF; box-shadow: 0 10px 20px rgba(47,53,38,.15);">
                                Send Message
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</section>