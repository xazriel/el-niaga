<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tentang Kami — Ssubsclub</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('sclublogo.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
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
                <a href="{{ route('articles.index') }}" class="nav-link font-bold hover:text-gray-400 uppercase text-[11px] tracking-widest">Artikel</a>
                <a href="{{ route('about-us') }}" class="nav-link font-bold hover:text-gray-400 uppercase text-[11px] tracking-widest" style="color: #1E1E24; border-bottom: 1px solid #1E1E24; padding-bottom: 2px;">Tentang Kami</a>
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

    {{-- About Content --}}
    <main class="max-w-4xl mx-auto px-6 py-20">
        
        <div class="text-center mb-16">
            <span class="text-[9px] uppercase tracking-[0.4em] text-brand-olive font-black block mb-2">Ssubsclub Story</span>
            <h1 class="text-4xl font-light tracking-wide uppercase">Tentang Kami</h1>
        </div>

        <div class="prose prose-lg max-w-none text-[13px] text-gray-700 leading-loose tracking-wide space-y-8 text-center">
            <p>
                Ssubsclub hadir melalui kesederhanaan yang terasa tenang, anggun, dan bermakna. 
                Kami percaya bahwa modesty bukan sekadar cara berpakaian, tetapi juga cara membawa diri dengan iman, ketenangan, dan keindahan yang tidak berlebihan.
            </p>
            <p>
                Setiap koleksi dirancang dengan perhatian pada detail, kenyamanan, dan siluet yang elegan untuk menemani perempuan muslimah dalam setiap langkahnya. Kami memadukan bahan-bahan premium berkualitas tinggi dengan jahitan yang rapi, memastikan setiap helai pakaian mencerminkan kualitas terbaik.
            </p>
            
            <div class="py-12">
                <span class="block text-2xl font-light text-[#1E1E24] italic">"Luxury in Modesty. Elegance with Iman."</span>
            </div>

            <p>
                Melalui komitmen ini, Ssubsclub terus menginspirasi muslimah modern untuk tampil percaya diri tanpa harus mengesampingkan syariat. Kami percaya bahwa keanggunan sejati terpancar dari dalam hati yang damai.
            </p>
        </div>

    </main>

    {{-- Footer --}}
    <footer class="bg-[#1E1E24] text-white mt-32 py-12 text-center text-[10px] tracking-widest uppercase">
        &copy; 2026 Ssubsclub Official. All Rights Reserved.
    </footer>

</body>
</html>
