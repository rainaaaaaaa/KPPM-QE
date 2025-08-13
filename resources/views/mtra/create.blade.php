@extends('layouts.app')

@section('page-title', 'Tambah Project Mitra')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <!-- Header -->
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-900">Tambah Project Mitra Baru</h2>
            <p class="text-sm text-gray-600 mt-1">Isi informasi project Mitra dengan lengkap</p>
        </div>

        <form method="POST" action="{{ route('mtra.store') }}" enctype="multipart/form-data" class="p-6">
            @csrf
            
            @if ($errors->any())
                <div class="mb-6 p-4 bg-gradient-to-r from-red-50 to-red-100 border border-red-200 text-red-700 rounded-lg">
                    <div class="flex items-center mb-2">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="font-medium">Terjadi kesalahan:</span>
                    </div>
                    <ul class="list-disc list-inside text-sm space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Left Column -->
                <div class="space-y-6">
                    <!-- Basic Info -->
                    <div>
                        <label for="nomor_kontrak" class="block text-sm font-medium text-gray-700 mb-2">Nomor Kontrak *</label>
                        <input type="text" 
                               id="nomor_kontrak" 
                               name="nomor_kontrak" 
                               value="{{ old('nomor_kontrak') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500"
                               placeholder="Contoh: MITRA-001-2024"
                               required>
                    </div>

                    <div>
                        <label for="lokasi" class="block text-sm font-medium text-gray-700 mb-2">Lokasi *</label>
                        <input type="text" 
                               id="lokasi" 
                               name="lokasi" 
                               value="{{ old('lokasi') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500"
                               placeholder="Contoh: Jakarta Pusat"
                               required>
                    </div>

                    <div>
                        <label for="jenis" class="block text-sm font-medium text-gray-700 mb-2">Jenis Project *</label>
                        <select id="jenis" 
                                name="jenis" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500"
                                required>
                            <option value="">Pilih Jenis Project</option>
                            <option value="recovery" {{ old('jenis') == 'recovery' ? 'selected' : '' }}>Recovery</option>
                            <option value="preventif" {{ old('jenis') == 'preventif' ? 'selected' : '' }}>Preventif</option>
                            <option value="relokasi" {{ old('jenis') == 'relokasi' ? 'selected' : '' }}>Relokasi</option>
                        </select>
                    </div>

                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status *</label>
                        <select id="status" name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500" required>
                            <option value="planning" {{ old('status', 'planning') == 'planning' ? 'selected' : '' }}>Planning</option>
                            <option value="berjalan" {{ old('status') == 'berjalan' ? 'selected' : '' }}>Berjalan</option>
                            <option value="selesai" {{ old('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        </select>
                    </div>

                    <div>
                        <label for="keterangan" class="block text-sm font-medium text-gray-700 mb-2">Keterangan</label>
                        <textarea id="keterangan" 
                                  name="keterangan" 
                                  rows="4"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500"
                                  placeholder="Tambahkan keterangan tambahan tentang project ini...">{{ old('keterangan') }}</textarea>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="space-y-6">
                    {{-- Hapus input hidden latitude dan longitude --}}

                    {{-- Hapus seluruh blok Maps Section (peta) --}}

                    <!-- Photo Upload Section -->
                    <div>
                        <label for="photos" class="block text-sm font-medium text-gray-700 mb-2">Foto Project</label>
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-red-400 transition-all duration-200 bg-gradient-to-br from-gray-50 to-gray-100">
                            <input type="file" 
                                   id="photos" 
                                   name="photos[]" 
                                   accept="image/*"
                                   multiple
                                   class="hidden">
                            <label for="photos" class="cursor-pointer">
                                <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                </svg>
                                <p class="text-sm text-gray-600 mb-2">Klik untuk memilih foto atau drag & drop</p>
                                <p class="text-xs text-gray-500">Format: JPG, PNG, GIF. Maksimal 2MB per foto. Bisa upload lebih dari satu foto.</p>
                            </label>
                        </div>
                    </div>

                    <!-- Photo Preview -->
                    <div id="photoPreview" class="grid grid-cols-2 md:grid-cols-3 gap-3 mb-4"></div>
                    <script>
                        // Preview foto sebelum submit
                        document.getElementById('photos').addEventListener('change', function(e) {
                            const preview = document.getElementById('photoPreview');
                            preview.innerHTML = '';
                            Array.from(e.target.files).forEach(file => {
                                if (!file.type.startsWith('image/')) return;
                                const reader = new FileReader();
                                reader.onload = function(ev) {
                                    const img = document.createElement('img');
                                    img.src = ev.target.result;
                                    img.className = 'w-full h-32 object-cover rounded-lg border border-gray-200';
                                    preview.appendChild(img);
                                };
                                reader.readAsDataURL(file);
                            });
                        });
                    </script>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-200 mt-8">
                <a href="{{ route('mtra.index') }}" 
                   class="px-6 py-2 text-gray-700 bg-gradient-to-r from-gray-100 to-gray-50 rounded-lg hover:from-gray-200 hover:to-gray-100 transition-all duration-200 border border-gray-300">
                    Batal
                </a>
                <button type="submit" 
                        class="px-6 py-2 bg-gradient-to-r from-red-600 to-red-500 text-white rounded-lg hover:from-red-700 hover:to-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-all duration-200 font-medium shadow-sm">
                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                    </svg>
                    Kirim Project
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Hapus seluruh script dan style Leaflet (peta) di bawah file --}}
@endsection 