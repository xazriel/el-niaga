<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $article->title }} — Ssubsclub</title>
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

    {{-- Main Read Article --}}
    <main class="max-w-4xl mx-auto px-6 py-16">
        
        {{-- Back --}}
        <a href="{{ route('articles.index') }}" class="inline-flex items-center gap-2 text-[9px] font-bold text-gray-400 hover:text-black uppercase tracking-widest mb-10">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Daftar
        </a>

        {{-- Meta --}}
        <div class="mb-6">
            <span class="text-[9px] font-bold tracking-widest text-[#2F3526] uppercase block mb-3">{{ $article->published_at ? $article->published_at->format('d F Y') : $article->created_at->format('d F Y') }}</span>
            <h1 class="text-3xl md:text-4xl font-light leading-tight text-gray-900 uppercase tracking-wide">{{ $article->title }}</h1>
        </div>

        {{-- Cover Image --}}
        @if($article->image)
            <div class="aspect-[16/9] w-full bg-gray-50 overflow-hidden rounded-3xl mb-12 shadow-sm">
                <img src="{{ asset('storage/' . $article->image) }}" alt="{{ $article->title }}" class="w-full h-full object-cover">
            </div>
        @endif

        {{-- Content body --}}
        <article class="prose prose-lg max-w-none text-[13px] text-gray-700 leading-loose tracking-wide border-b border-gray-100 pb-16">
            {!! nl2br(e($article->content)) !!}
        </article>

        {{-- Related/Recent Articles Section --}}
        @if($recentArticles->isNotEmpty())
            <div class="mt-16">
                <h4 class="text-[11px] font-bold uppercase tracking-[0.25em] text-gray-900 mb-8 border-b pb-3">Artikel Rekomendasi</h4>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @foreach($recentArticles as $ra)
                        <div class="group">
                            <div class="aspect-[16/10] bg-gray-50 rounded-2xl overflow-hidden mb-4">
                                @if($ra->image)
                                    <img src="{{ asset('storage/' . $ra->image) }}" class="w-full h-full object-cover transition duration-700 group-hover:scale-105">
                                @else
                                    <div class="w-full h-full bg-gray-100 flex items-center justify-center text-[8px] text-gray-400 uppercase tracking-widest font-bold">Ssubsclub</div>
                                @endif
                            </div>
                            <h5 class="text-[11px] font-bold uppercase tracking-wide text-gray-800 group-hover:text-[#2F3526] transition-colors leading-snug">
                                <a href="{{ route('articles.show', $ra->slug) }}">{{ $ra->title }}</a>
                            </h5>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    </main>

    {{-- Footer --}}
    <footer class="bg-[#2F3526] text-white mt-32 py-12 text-center text-[10px] tracking-widest uppercase">
        &copy; 2026 Ssubsclub Official. All Rights Reserved.
    </footer>

</body>
</html>
