<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Artikel & Inspirasi — Ssubsclub</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('sclublogo.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #FFFFFF; color: #111111; }
        .nav-link { font-size: 0.7rem; letter-spacing: 0.2em; transition: all 0.3s ease; }
    </style>
</head>
<body class="antialiased bg-white text-gray-900">

    {{-- Include Header Navbar --}}
    <header class="sticky top-0 z-50 bg-white border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-6 h-20 flex justify-between items-center">
            
            {{-- LOGO --}}
            <div class="shrink-0 flex items-center">
                <a href="{{ route('home') }}">
                    <img src="{{ asset('sclublogo.png') }}" alt="Ssubsclub" class="h-14 md:h-20 w-auto object-contain">
                </a>
            </div>

            {{-- MENU NAVIGATION --}}
            <div class="hidden md:flex space-x-10 items-center">
                <a href="{{ route('home') }}" class="nav-link font-bold hover:text-gray-400 uppercase text-[11px] tracking-widest">Home</a>
                <a href="{{ route('products.index') }}" class="nav-link font-bold hover:text-gray-400 uppercase text-[11px] tracking-widest">Produk</a>
                <a href="{{ route('articles.index') }}" class="nav-link font-bold hover:text-gray-400 uppercase text-[11px] tracking-widest" style="color: #2F3526; border-bottom: 1px solid #2F3526; padding-bottom: 2px;">Artikel</a>
                <a href="{{ route('home') }}#about" class="nav-link font-bold hover:text-gray-400 uppercase text-[11px] tracking-widest">Tentang Kami</a>
            </div>

            {{-- RIGHT ICONS --}}
            <div class="flex items-center space-x-4">
                <x-cart-count />
                @auth
                    <a href="{{ Auth::user()->role === 'admin' ? route('admin.dashboard') : route('dashboard') }}" class="p-1.5 text-gray-600 hover:text-black transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
                        </svg>
                    </a>
                @else
                    <button @click="window.dispatchEvent(new CustomEvent('open-login'))" class="p-1.5 text-gray-600 hover:text-black transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
                        </svg>
                    </button>
                @endauth
            </div>

        </div>
    </header>

    {{-- Main Articles List --}}
    <main class="max-w-7xl mx-auto px-6 py-16">
        
        {{-- Section Title --}}
        <div class="text-center mb-16">
            <span class="text-[9px] uppercase tracking-[0.4em] text-brand-olive font-black block mb-2">Ssubsclub Journal</span>
            <h1 class="text-4xl font-light tracking-wide uppercase">Artikel &amp; Inspirasi</h1>
        </div>

        {{-- Articles Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @forelse($articles as $art)
                <div class="group bg-white rounded-3xl overflow-hidden border border-gray-100 shadow-sm flex flex-col justify-between">
                    <div>
                        <div class="aspect-[16/10] bg-gray-50 overflow-hidden relative">
                            @if($art->image)
                                <img src="{{ asset('storage/' . $art->image) }}" class="w-full h-full object-cover transition duration-700 group-hover:scale-105">
                            @else
                                <div class="w-full h-full bg-gray-100 flex items-center justify-center text-[10px] text-gray-400 uppercase tracking-widest font-bold">Ssubsclub Style</div>
                            @endif
                        </div>
                        <div class="p-8">
                            <span class="text-[9px] text-gray-400 font-bold uppercase tracking-widest block mb-2">{{ $art->published_at ? $art->published_at->format('d M Y') : $art->created_at->format('d M Y') }}</span>
                            <h3 class="text-lg font-bold text-gray-800 uppercase tracking-wide mb-4 leading-snug group-hover:text-[#2F3526] transition-colors">
                                <a href="{{ route('articles.show', $art->slug) }}">{{ $art->title }}</a>
                            </h3>
                            <p class="text-[11px] text-gray-500 leading-loose line-clamp-3">
                                {{ strip_tags($art->content) }}
                            </p>
                        </div>
                    </div>
                    <div class="px-8 pb-8 pt-4">
                        <a href="{{ route('articles.show', $art->slug) }}" class="inline-block border-b border-black text-[9px] font-bold uppercase tracking-widest pb-1 hover:border-[#2F3526] hover:text-[#2F3526] transition-colors">Baca Selengkapnya</a>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-32 border border-dashed border-gray-100 rounded-3xl">
                    <p class="text-gray-400 text-xs tracking-widest uppercase">Belum ada artikel yang dipublikasikan.</p>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if($articles->hasPages())
            <div class="mt-16 pt-8 border-t border-gray-100">
                {{ $articles->links() }}
            </div>
        @endif

    </main>

    {{-- Footer --}}
    <footer class="bg-[#2F3526] text-white mt-32 py-12 text-center text-[10px] tracking-widest uppercase">
        &copy; 2026 Ssubsclub Official. All Rights Reserved.
    </footer>

</body>
</html>
