<x-guest-layout>
    <style>
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        
        .font-heavy {
            font-family: 'Plus Jakarta Sans', sans-serif !important;
            font-weight: 800;
        }
    </style>

    {{-- Container utama --}}
    <div class="fixed inset-0 min-h-screen w-full flex flex-col lg:flex-row bg-[#050506] overflow-hidden" style="min-width: 100vw;">
        
        {{-- SISI KIRI (Branding & Visuals) --}}
        <div class="w-full lg:w-1/2 h-[30vh] lg:h-full bg-[#050506] border-b lg:border-b-0 lg:border-r border-[#1C1C20] flex flex-col justify-between pt-8 lg:pt-12 px-10 lg:px-16 pb-6 lg:pb-16 relative overflow-hidden shrink-0">
            
            {{-- BACKGROUND TEXT --}}
            <div class="absolute inset-0 flex flex-col justify-center items-center pointer-events-none select-none opacity-[0.06]">
                <div class="text-[12vw] font-black tracking-tighter uppercase leading-none text-white font-heavy select-none">REAL</div>
                <div class="text-[14vw] font-black tracking-widest uppercase leading-none text-white font-heavy select-none">DOPE</div>
                <div class="text-[12vw] font-black tracking-tighter uppercase leading-none text-white font-heavy select-none">SHIT</div>
            </div>

            {{-- LOGO & BRANDING --}}
            <div class="relative z-10 flex flex-row lg:flex-col justify-between lg:justify-start items-center lg:items-start w-full">
                <a href="{{ route('home') }}" class="block">
                    <img src="{{ asset('sclublogo.png') }}"
                         alt="Ssubsclub"
                         class="h-[80px] lg:h-36 w-auto object-contain brightness-0 invert opacity-95 -ml-4 lg:-ml-10">
                </a>
                <div class="text-left mt-2">
                    <p class="text-[#10B981] text-[10px] tracking-[0.4em] uppercase font-bold">Est. MMXXVI</p>
                    <p class="text-white/40 text-[8px] tracking-[0.2em] uppercase mt-1">GEN-Z STREETWEAR / HIPHOP CULTURE</p>
                </div>
            </div>

            {{-- FOOTER BRAND TAG (Desktop Only) --}}
            <div class="hidden lg:block relative z-10">
                <p class="text-white/40 text-[9px] uppercase tracking-[0.3em] leading-loose max-w-xs border-l-2 border-[#10B981] pl-3">
                    SSUBSCLUB® // REAL DOPE SHIT<br>
                    UNDERGROUND STREET CULTURE INDONESIA
                </p>
            </div>
        </div>

        {{-- SISI KANAN (Form Card) --}}
        <div class="w-full lg:w-1/2 h-[70vh] lg:h-full flex flex-col items-center justify-start lg:justify-center p-0 lg:p-8 bg-[#050506] relative">
            
            <div class="w-full h-full lg:h-auto max-w-none lg:max-w-[390px] py-10 px-10 lg:px-12 bg-[#0C0C0E] border lg:border border-transparent lg:border-[#1C1C20] rounded-t-[40px] lg:rounded-3xl overflow-y-auto no-scrollbar shadow-[0_-10px_40px_rgba(0,0,0,0.5)] lg:shadow-2xl">
                
                {{-- Header Login --}}
                <div class="flex flex-col items-start space-y-2 mb-8 lg:mb-10">
                    <h3 class="text-3xl font-black text-white tracking-tighter uppercase leading-tight font-heavy">
                        LOGIN
                    </h3>
                    <p class="text-[9px] font-bold tracking-[0.3em] uppercase text-[#10B981]">Access your underground portal</p>
                </div>

                <form method="POST" action="{{ route('login') }}" class="space-y-6 lg:space-y-8">
                    @csrf

                    {{-- Input Email --}}
                    <div class="border-b border-[#1C1C20] pb-2 focus-within:border-[#10B981] transition-colors duration-500">
                        <label class="block text-[9px] font-bold tracking-[0.2em] uppercase text-gray-400 mb-1">Email Address</label>
                        <input type="email" name="email" :value="old('email')" required autofocus 
                            class="w-full border-none bg-transparent p-0 focus:ring-0 text-sm tracking-wide text-white placeholder-gray-700"
                            placeholder="username@gmail.com">
                    </div>

                    {{-- Input Password --}}
                    <div class="border-b border-[#1C1C20] pb-2 focus-within:border-[#10B981] transition-colors duration-500" 
                        x-data="{ show: false }">
                        <div class="flex justify-between items-center mb-1">
                            <label class="text-[9px] font-bold tracking-[0.2em] uppercase text-gray-400">Password</label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-[9px] tracking-widest text-gray-500 hover:text-[#10B981] transition-colors">Forgot?</a>
                            @endif
                        </div>
                        <div class="relative">
                            <input :type="show ? 'text' : 'password'" 
                                name="password" 
                                required
                                class="w-full border-none bg-transparent p-0 pr-10 focus:ring-0 text-sm tracking-wide text-white placeholder-gray-700"
                                placeholder="••••••••">
                            
                            <button type="button" 
                                    @click="show = !show" 
                                    class="absolute right-0 top-1/2 -translate-y-1/2 text-gray-600 hover:text-[#10B981] transition-colors focus:outline-none">
                                
                                <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>

                                <svg x-show="show" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display: none;">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    {{-- ERROR NOTIFICATION --}}
                    @if ($errors->any())
                        <div class="animate-in fade-in slide-in-from-top-1 duration-300 text-center lg:text-left">
                            <p class="text-[10px] tracking-[0.2em] uppercase text-red-500 font-bold">
                                Incorrect email or password.
                            </p>
                        </div>
                    @endif

                    {{-- Submit Button --}}
                    <div class="pt-2">
                        <button type="submit" class="w-full py-5 bg-[#10B981] text-[#050506] text-[11px] font-black tracking-[0.5em] uppercase hover:bg-[#059669] transition-all hover:scale-[1.02] shadow-[0_4px_20px_rgba(16,185,129,0.15)] active:scale-[0.98] rounded-xl lg:rounded-xl font-heavy">
                            LOGIN
                        </button>
                    </div>

                    {{-- Link Register --}}
                    <p class="text-center lg:text-left text-[10px] tracking-[0.2em] text-gray-500 uppercase pt-2 pb-6">
                        New here? <a href="{{ route('register') }}" class="text-[#10B981] font-black border-b border-[#10B981]/20 ml-1">Join Us</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>