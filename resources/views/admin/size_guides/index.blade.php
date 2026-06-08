<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg text-gray-800 leading-tight tracking-tight">
            {{ __('Size Guide Templates') }}
        </h2>
    </x-slot>

    <div class="py-10 bg-[#F9F9F7]">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Header Section --}}
            <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between px-4 sm:px-0 gap-4">
                <div>
                    <h3 class="text-xl font-bold text-gray-900 tracking-tight">Size Guides</h3>
                    <p class="text-[10px] uppercase tracking-[0.2em] text-gray-400 mt-1 font-medium">Manajemen Tabel Ukuran Ssubsclub</p>
                    <div class="h-1 w-10 bg-[#2F3526] mt-3 rounded-full"></div>
                </div>
                
                <a href="{{ route('admin.size-guides.create') }}" 
                    class="inline-flex items-center px-5 py-2.5 bg-[#2F3526] text-white text-[10px] font-bold uppercase tracking-[0.15em] rounded-lg hover:bg-[#4A5043] transition-all duration-200 shadow-sm active:scale-95">
                    <span class="mr-2 text-sm">+</span> Tambah Template
                </a>
            </div>

            @if(session('success'))
                <div class="mb-6 mx-4 sm:mx-0 p-3 bg-white border-l-4 border-[#2F3526] shadow-sm rounded-r-md flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-4 w-4 text-[#2F3526]" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-[10px] uppercase tracking-widest font-bold text-gray-700">
                            {{ session('success') }}
                        </p>
                    </div>
                </div>
            @endif

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 px-4 sm:px-0">
                @forelse($templates as $template)
                    <div class="group bg-white rounded-xl border border-gray-100 overflow-hidden shadow-sm hover:shadow-md transition-all duration-300">
                        {{-- Image Preview Area --}}
                        <div class="relative h-40 bg-[#F3F4F1] flex items-center justify-center overflow-hidden">
                            @if($template->image)
                                <img src="{{ asset('storage/' . $template->image) }}" class="w-full h-full object-contain p-4 transition-transform duration-500 group-hover:scale-105">
                            @else
                                <div class="flex flex-col items-center">
                                    <svg class="w-8 h-8 text-gray-200 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <span class="text-gray-400 italic text-[9px] uppercase tracking-widest">No Image</span>
                                </div>
                            @endif
                            
                            {{-- Badge --}}
                            <div class="absolute top-3 right-3">
                                <span class="px-2.5 py-1 bg-white/90 backdrop-blur-sm rounded-md shadow-sm text-[9px] font-black uppercase tracking-widest text-[#2F3526] border border-gray-50">
                                    {{ $template->type }}
                                </span>
                            </div>
                        </div>

                        {{-- Content Area --}}
                        <div class="p-5">
                            <h4 class="text-[12px] font-bold text-gray-800 uppercase tracking-wider truncate mb-4 group-hover:text-[#2F3526] transition-colors">
                                {{ $template->name }}
                            </h4>
                            
                            <div class="flex items-center justify-between border-t border-gray-50 pt-4">
                                <a href="{{ route('admin.size-guides.edit', $template->id) }}" 
                                    class="inline-flex items-center text-[9px] font-bold uppercase tracking-widest text-gray-400 hover:text-blue-600 transition-all">
                                    Edit
                                </a>

                                <form action="{{ route('admin.size-guides.destroy', $template->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus template ini?')">
                                    @csrf 
                                    @method('DELETE')
                                    <button type="submit" class="text-[9px] font-bold uppercase tracking-widest text-red-300 hover:text-red-500 transition-all">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-20 bg-white rounded-xl border border-dashed border-gray-200 text-center flex flex-col items-center justify-center">
                        <p class="text-gray-400 text-[10px] font-bold uppercase tracking-[0.2em]">Belum ada data template.</p>
                        <a href="{{ route('admin.size-guides.create') }}" class="mt-4 text-[9px] font-bold text-[#2F3526] uppercase tracking-widest border-b border-[#2F3526] pb-0.5">Tambah Data</a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>