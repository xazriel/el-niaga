<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Kategori') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm rounded-lg">
                <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Nama Kategori</label>
                        <input type="text" name="name" value="{{ $category->name }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-black focus:border-black" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Tipe Kategori</label>
                        <select name="type" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-black focus:border-black" required>
                            <option value="standard" {{ $category->type === 'standard' ? 'selected' : '' }}>Standard (S, M, L, XL, XXL, All Size)</option>
                            <option value="kids" {{ $category->type === 'kids' ? 'selected' : '' }}>Kids (3-4 Years, 5-6 Years, etc.)</option>
                            <option value="khiban" {{ $category->type === 'khiban' ? 'selected' : '' }}>Khiban (Mini, Midi)</option>
                            <option value="defect" {{ $category->type === 'defect' ? 'selected' : '' }}>Defect (Minor, Major)</option>
                        </select>
                    </div>

                    <div class="flex justify-end gap-2">
                        <a href="{{ route('admin.categories.index') }}" class="bg-gray-200 px-4 py-2 rounded-md transition hover:bg-gray-300 text-sm">Batal</a>
                        <button type="submit" class="bg-black text-white px-4 py-2 rounded-md transition hover:bg-gray-800 text-sm">Update Kategori</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
