<x-guest-layout>
    {{-- Container utama full screen --}}
    <div class="fixed inset-0 min-h-screen w-full flex flex-row bg-[#FDFDFB] overflow-hidden" style="min-width: 100vw;">
        
        {{-- SISI KIRI: Branding & Aesthetic Elements --}}
        <div class="hidden lg:flex w-1/2 bg-[#2F3526] flex-col justify-between pt-10 px-16 pb-16 relative overflow-hidden">
            
            {{-- ELEMEN GEOMETRIS --}}
            <div class="absolute top-[35%] -right-20 w-80 h-80 border border-white/[0.03] rounded-full pointer-events-none"></div>
            <div class="absolute bottom-20 right-12 w-32 h-32 border border-white/[0.05] rounded-full pointer-events-none"></div>
            <div class="absolute left-10 top-1/4 h-1/2 w-[1px] bg-gradient-to-b from-transparent via-white/[0.05] to-transparent pointer-events-none"></div>

            {{-- LOGO & TAHUN --}}
            <div class="relative z-10">
                <a href="/" class="block">
                    <img src="{{ asset('sclublogo.png') }}"
                         alt="Ssubsclub"
                         class="h-40 w-auto object-contain brightness-0 invert opacity-95 -ml-12 -mt-2">
                </a>
                <p class="text-[#6B705C] text-[10px] tracking-[0.4em] uppercase mt-0 ml-1">Est. MMXXVI</p>
            </div>

            {{-- QUOTE --}}
            <div class="relative z-10">
                <p class="text-white/30 text-[9px] uppercase tracking-[0.4em] leading-loose max-w-xs ml-1">
                    "Simplicity is the ultimate sophistication."
                </p>
            </div>

            {{-- Background Curve --}}
            <div class="absolute inset-0 opacity-5 pointer-events-none">
                <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                    <path d="M0 100 C 30 0 70 0 100 100" stroke="white" fill="transparent" stroke-width="0.1" />
                </svg>
            </div>
        </div>

        {{-- SISI KANAN: Forgot Password Form --}}
        <div class="w-full lg:w-1/2 flex flex-col items-center justify-center p-8 bg-white overflow-y-auto">
            <div class="w-full max-w-[380px] py-10">
                
                {{-- Header --}}
                <div class="flex flex-col items-start space-y-2 mb-8">
                    <h3 class="text-3xl font-extralight text-[#2F3526] tracking-tight leading-tight uppercase">
                        Reset
                    </h3>
                    <p class="text-[9px] font-bold tracking-[0.3em] uppercase text-gray-400">Recover your access</p>
                </div>

                {{-- Deskripsi Bantuan --}}
                <div class="mb-10 text-[11px] leading-relaxed tracking-wider text-gray-500 uppercase">
                    {{ __('Forgot your password? No problem. Enter your email and we will send a reset link to your inbox.') }}
                </div>

                {{-- Session Status (Pesan Berhasil Kirim Email) --}}
                <x-auth-session-status class="mb-6 text-[10px] font-bold tracking-widest text-[#2F3526] uppercase" :status="session('status')" />

                <form method="POST" action="{{ route('password.email') }}" class="space-y-12">
                    @csrf

                    {{-- Email Address --}}
                    <div class="border-b border-gray-100 pb-2 focus-within:border-[#2F3526] transition-colors duration-500">
                        <label for="email" class="block text-[9px] font-bold tracking-[0.2em] uppercase text-gray-400 mb-1">Registered Email</label>
                        <input id="email" type="email" name="email" :value="old('email')" required autofocus 
                            class="w-full border-none bg-transparent p-0 focus:ring-0 text-sm tracking-wide text-gray-800 placeholder-gray-200"
                            placeholder="NAME@DOMAIN.COM">
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    {{-- Submit Button --}}
                    <div class="space-y-6">
                        <button type="submit" class="w-full py-5 bg-[#2F3526] text-white text-[10px] font-bold tracking-[0.5em] uppercase hover:bg-[#1a1f16] transition-all shadow-lg active:scale-[0.98]">
                            {{ __('Send Reset Link') }}
                        </button>

                        {{-- Back to Login --}}
                        <div class="text-center">
                            <a href="{{ route('login') }}" class="text-[10px] tracking-[0.3em] text-gray-400 uppercase hover:text-[#2F3526] transition-colors">
                                <span class="mr-2">←</span> Back to Login
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>