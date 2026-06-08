<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center font-helvetica">
            <h2 class="font-bold text-xs text-brand-primary tracking-widest uppercase">
                {{ __('Tulis Artikel Baru') }}
            </h2>
            <nav class="text-[9px] uppercase tracking-widest text-brand-olive font-bold">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-brand-primary">Dashboard</a> &gt; 
                <a href="{{ route('admin.articles.index') }}" class="hover:text-brand-primary">Artikel</a> &gt; 
                <span>Baru</span>
            </nav>
        </div>
    </x-slot>

    <div class="bg-brand-white min-h-screen py-8 px-4 sm:px-6 lg:px-8 font-helvetica rounded-[2rem]">
        <div class="max-w-3xl mx-auto">
            
            <a href="{{ route('admin.articles.index') }}" class="inline-flex items-center gap-2 text-[10px] font-bold text-brand-olive hover:text-brand-primary uppercase tracking-widest mb-8">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali ke Daftar
            </a>

            <div class="mb-10">
                <h3 class="text-3xl font-light text-brand-black tracking-wide">Tulis Artikel Baru</h3>
                <p class="text-[10px] uppercase tracking-[0.2em] text-brand-olive mt-1">Gunakan form di bawah ini untuk menerbitkan materi bacaan baru</p>
            </div>

            <div class="bg-brand-white p-8 rounded-[2rem] border border-brand-light shadow-sm">
                <form action="{{ route('admin.articles.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <div>
                        <label class="block text-[9px] font-bold uppercase tracking-widest text-brand-olive mb-2">Judul Artikel</label>
                        <input type="text" name="title" required placeholder="Tulis judul artikel..."
                            class="w-full bg-brand-light/20 border border-brand-light rounded-2xl px-5 py-3 text-[12px] placeholder-brand-olive/55 focus:outline-none focus:ring-1 focus:ring-brand-primary">
                    </div>

                    <div>
                        <label class="block text-[9px] font-bold uppercase tracking-widest text-brand-olive mb-2">Unggah Foto Utama</label>
                        <input type="file" name="image" accept="image/*"
                            class="w-full bg-brand-light/20 border border-brand-light rounded-2xl px-5 py-3 text-[11px] focus:outline-none focus:ring-1 focus:ring-brand-primary">
                        <span class="text-[8px] text-brand-olive mt-1 block">Rekomendasi rasio gambar lanskap (16:9). Ukuran maks 2MB.</span>
                    </div>

                    <div>
                        <label class="block text-[9px] font-bold uppercase tracking-widest text-brand-olive mb-2">Isi Artikel</label>
                        <textarea name="content" required rows="12" placeholder="Tulis isi konten artikel secara detail di sini..."
                            class="w-full bg-brand-light/20 border border-brand-light rounded-2xl px-5 py-4 text-[12px] placeholder-brand-olive/55 focus:outline-none focus:ring-1 focus:ring-brand-primary leading-relaxed"></textarea>
                    </div>

                    <div class="flex items-center gap-3">
                        <input type="checkbox" name="is_published" id="is_published" checked value="1" class="rounded text-brand-primary focus:ring-brand-primary">
                        <label for="is_published" class="text-[9px] font-bold uppercase tracking-widest text-brand-olive">Langsung Terbitkan (Publish)</label>
                    </div>

                    <button type="submit" class="w-full bg-brand-black text-brand-white py-4 rounded-full text-[10px] font-bold uppercase tracking-[0.2em] hover:bg-brand-primary transition">Terbitkan Artikel</button>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>
