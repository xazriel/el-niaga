<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center font-helvetica">
            <h2 class="font-bold text-xs text-brand-primary tracking-widest uppercase">
                {{ __('Kelola Artikel') }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('admin.articles.create') }}" class="bg-brand-primary text-brand-white px-6 py-2 rounded-full text-[9px] font-bold uppercase tracking-widest hover:bg-brand-olive transition">Tulis Artikel Baru</a>
            </div>
        </div>
    </x-slot>

    <div class="bg-brand-white min-h-screen py-8 px-4 sm:px-6 lg:px-8 font-helvetica rounded-[2rem]">
        <div class="max-w-7xl mx-auto">

            @if(session('success'))
                <div class="mb-8 p-5 rounded-2xl bg-brand-primary text-brand-white text-[10px] font-bold uppercase tracking-widest flex justify-between items-center">
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <div class="mb-10">
                <h3 class="text-3xl font-light text-brand-black tracking-wide">CMS Artikel</h3>
                <p class="text-[10px] uppercase tracking-[0.2em] text-brand-olive mt-1">Tulis dan terbitkan artikel gaya hidup muslim, panduan model, dan promosi</p>
            </div>

            <div class="bg-brand-white rounded-[2rem] border border-brand-light overflow-hidden shadow-sm">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-brand-light/30 border-b border-brand-light text-[9px] uppercase tracking-[0.2em] text-brand-olive font-black">
                                <th class="py-5 px-8">Gambar</th>
                                <th class="py-5 px-6">Judul Artikel</th>
                                <th class="py-5 px-6 text-center">Status</th>
                                <th class="py-5 px-6">Tanggal Rilis</th>
                                <th class="py-5 px-8 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-brand-light text-[11px] text-brand-black">
                            @forelse($articles as $art)
                                <tr class="hover:bg-brand-light/10 transition">
                                    <td class="py-5 px-8">
                                        @if($art->image)
                                            <img src="{{ asset('storage/' . $art->image) }}" class="w-16 h-10 object-cover rounded-lg">
                                        @else
                                            <div class="w-16 h-10 bg-brand-light rounded-lg flex items-center justify-center text-[7px] uppercase font-bold text-brand-olive font-bold">NO IMG</div>
                                        @endif
                                    </td>
                                    <td class="py-5 px-6">
                                        <span class="font-bold text-[12px] text-brand-primary block uppercase tracking-wide">{{ $art->title }}</span>
                                        <span class="text-[9px] text-brand-olive font-mono">/articles/{{ $art->slug }}</span>
                                    </td>
                                    <td class="py-5 px-6 text-center">
                                        @if($art->is_published)
                                            <span class="inline-block bg-brand-primary text-brand-white px-2 py-0.5 rounded text-[8px] font-bold uppercase tracking-widest">PUBLISHED</span>
                                        @else
                                            <span class="inline-block bg-brand-light text-brand-black px-2 py-0.5 rounded text-[8px] font-bold uppercase tracking-widest">DRAFT</span>
                                        @endif
                                    </td>
                                    <td class="py-5 px-6 text-brand-olive">
                                        {{ $art->published_at ? $art->published_at->format('d M Y H:i') : '-' }}
                                    </td>
                                    <td class="py-5 px-8 text-right">
                                        <div class="flex justify-end gap-3">
                                            <a href="{{ route('admin.articles.edit', $art->id) }}" class="text-[9px] font-bold uppercase tracking-widest text-brand-primary hover:underline">Edit</a>
                                            <span class="text-brand-light">|</span>
                                            <form action="{{ route('admin.articles.destroy', $art->id) }}" method="POST" onsubmit="return confirm('Hapus artikel ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-[9px] font-bold uppercase tracking-widest text-red-600 hover:underline">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-16 text-center text-brand-olive uppercase tracking-widest text-[10px]">Belum ada artikel terdaftar.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($articles->hasPages())
                    <div class="px-8 py-5 border-t border-brand-light bg-brand-light/10">
                        {{ $articles->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
