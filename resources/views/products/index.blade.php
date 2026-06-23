<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Katalog Produk — Ssubsclub</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('sclublogo.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #FFFFFF; color: #111111; }
        .nav-link { font-size: 0.7rem; letter-spacing: 0.2em; transition: all 0.3s ease; }
        .price-original { font-size: 10px; color: #c0c0c0; text-decoration: line-through; letter-spacing: 0.1em; }
        .price-normal, .price-sale { font-size: 12px; font-weight: 500; letter-spacing: 0.12em; }
        .category-btn.active { font-weight: 700; border-bottom: 2px solid #10B981; color: #10B981; }
    </style>
</head>
<body class="antialiased bg-white text-gray-900">

    {{-- Include Header Navbar (similar style to welcome.blade) --}}
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
                <a href="{{ route('products.index') }}" class="nav-link font-bold hover:text-gray-400 uppercase text-[11px] tracking-widest" style="color: #10B981; border-bottom: 1px solid #10B981; padding-bottom: 2px;">Produk</a>
                <a href="{{ route('articles.index') }}" class="nav-link font-bold hover:text-gray-400 uppercase text-[11px] tracking-widest">Artikel</a>
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

    {{-- Main Catalog --}}
    <main class="max-w-7xl mx-auto px-6 py-16">
        
        {{-- Section title --}}
        <div class="text-center mb-16">
            <span class="text-[9px] uppercase tracking-[0.4em] text-brand-olive font-black block mb-2">Ssubsclub</span>
            <h1 class="text-4xl font-light tracking-wide uppercase">Koleksi Produk</h1>
        </div>

        {{-- Filters & Sort Bar --}}
        <div class="mb-12 border-b border-gray-100 pb-6 flex flex-col md:flex-row justify-between items-center gap-6">
            
            {{-- Categories --}}
            <div class="flex flex-wrap gap-6 items-center">
                <a href="{{ route('products.index', array_merge(request()->query(), ['category' => ''])) }}" 
                    class="category-btn text-[10px] uppercase tracking-[0.2em] pb-1 hover:text-[#10B981] transition {{ !request('category') ? 'active' : '' }}">
                    All Collection
                </a>
                @foreach($categories as $cat)
                    <a href="{{ route('products.index', array_merge(request()->query(), ['category' => $cat->slug])) }}" 
                        class="category-btn text-[10px] uppercase tracking-[0.2em] pb-1 hover:text-[#10B981] transition {{ request('category') === $cat->slug ? 'active' : '' }}">
                        {{ $cat->name }}
                    </a>
                @endforeach
            </div>

            {{-- Sort & Search --}}
            <form action="{{ route('products.index') }}" method="GET" class="flex flex-col sm:flex-row gap-4 w-full md:w-auto items-center">
                @if(request('category'))
                    <input type="hidden" name="category" value="{{ request('category') }}">
                @endif

                <div class="relative w-full sm:w-64">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="CARI PRODUK..."
                        class="w-full bg-gray-50 border border-gray-200 rounded-full px-5 py-2.5 text-[9px] tracking-widest uppercase focus:outline-none focus:ring-1 focus:ring-[#10B981]">
                </div>

                <select name="sort" onchange="this.form.submit()"
                    class="w-full sm:w-auto bg-gray-50 border border-gray-200 rounded-full px-5 py-2.5 text-[9px] font-bold uppercase tracking-widest focus:outline-none">
                    <option value="newest" {{ request('sort') === 'newest' ? 'selected' : '' }}>Terbaru</option>
                    <option value="price_asc" {{ request('sort') === 'price_asc' ? 'selected' : '' }}>Harga: Terendah</option>
                    <option value="price_desc" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>Harga: Tertinggi</option>
                    <option value="name_asc" {{ request('sort') === 'name_asc' ? 'selected' : '' }}>Nama: A-Z</option>
                </select>
            </form>

        </div>

        {{-- Product Grid --}}
        <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-x-6 gap-y-12">
            @forelse($products as $product)
                <a href="{{ route('product.details', $product->slug) }}" class="group block no-underline">
                    <div class="relative overflow-hidden aspect-[3/4] bg-[#E9E9E9] mb-6 rounded-2xl">
                        @if($product->defect_type)
                            <div class="absolute top-3 left-3 z-10 bg-[#C0392B] text-white text-[8px] font-bold tracking-widest uppercase px-2 py-1 select-none rounded">
                                DEFECT {{ $product->defect_type }}
                            </div>
                        @endif
                        @if($product->custom_tag)
                            <div class="absolute top-3 right-3 z-10 bg-[#10B981] text-white text-[8px] font-bold tracking-widest uppercase px-2 py-1 select-none rounded">
                                {{ $product->custom_tag }}
                            </div>
                        @endif
                        @if($product->images->first())
                            <img src="{{ asset('storage/' . $product->images->first()->image_path) }}" alt="{{ $product->name }}" class="w-full h-full object-cover transition duration-1000 group-hover:scale-105">
                        @else
                            <div class="flex items-center justify-center h-full text-gray-300 text-[10px] tracking-widest uppercase">No Image</div>
                        @endif
                    </div>
                    <div class="text-center">
                        <h4 class="text-[11px] font-bold tracking-widest uppercase mb-1 text-gray-800">{{ $product->name }}</h4>
                        <p class="text-[9px] text-gray-400 mb-2 uppercase tracking-widest">{{ $product->category->name ?? 'Collection' }}</p>

                        <div class="flex flex-col items-center gap-1">
                            @if($product->original_price && $product->original_price > $product->price)
                                <span class="price-original">IDR {{ number_format($product->original_price, 0, ',', '.') }}</span>
                                <span class="price-sale text-red-600">IDR {{ number_format($product->price, 0, ',', '.') }}</span>
                            @else
                                <span class="price-normal">IDR {{ number_format($product->price, 0, ',', '.') }}</span>
                            @endif
                        </div>
                    </div>
                </a>
            @empty
                <div class="col-span-full text-center py-32 border border-dashed border-gray-100 rounded-3xl">
                    <p class="text-gray-400 text-xs tracking-widest uppercase">Koleksi produk tidak ditemukan.</p>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if($products->hasPages())
            <div class="mt-16 pt-8 border-t border-gray-100">
                {{ $products->links() }}
            </div>
        @endif

    </main>

    {{-- Footer similar to welcome page --}}
    <footer class="bg-[#0B0C0E] text-white mt-32 py-12 text-center text-[10px] tracking-widest uppercase">
        &copy; 2026 Ssubsclub Official. All Rights Reserved.
    </footer>

</body>
</html>
