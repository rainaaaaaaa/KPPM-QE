@extends('layouts.app')

@section('page-title', 'Detail Project Mitra')

@section('content')
<!-- Success/Error Messages -->
@if(session('success'))
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 mb-6">
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
        <div class="flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            <strong>Berhasil!</strong> {{ session('success') }}
        </div>
    </div>
</div>
@endif

@if(session('error'))
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 mb-6">
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
        <div class="flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
            <strong>Error!</strong> {{ session('error') }}
        </div>
    </div>
</div>
@endif

<!-- Debug Info -->

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <!-- Header -->
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-semibold text-gray-900">Detail Project Mitra</h2>
                    <p class="text-sm text-gray-600 mt-1">{{ $mtraProject->nomor_kontrak }}</p>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('mtra.index') }}"
                       class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                        Kembali
                    </a>
                </div>
            </div>
        </div>

        <div class="p-6">

            <!-- Project Information -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Kontrak</label>
                        <p class="text-gray-900 font-medium">{{ $mtraProject->nomor_kontrak }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Lokasi</label>
                        <p class="text-gray-900">{{ $mtraProject->lokasi }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Project</label>
                        @if($mtraProject->jenis)
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                            @if($mtraProject->jenis == 'recovery') bg-green-100 text-green-800
                            @elseif($mtraProject->jenis == 'preventif') bg-yellow-100 text-yellow-800
                            @else bg-blue-100 text-blue-800
                            @endif">
                            {{ ucfirst($mtraProject->jenis) }}
                        </span>
                        @else
                        <p class="text-gray-500">Tidak ada data</p>
                        @endif
                    </div>
                </div>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Dibuat</label>
                        <p class="text-gray-900">{{ $mtraProject->created_at ? $mtraProject->created_at->format('d M Y H:i') : 'Tidak ada data' }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Terakhir Diupdate</label>
                        <p class="text-gray-900">{{ $mtraProject->updated_at ? $mtraProject->updated_at->format('d M Y H:i') : 'Tidak ada data' }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        @if($mtraProject->status)
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                            @if($mtraProject->status == 'selesai') bg-green-100 text-green-800
                            @else bg-yellow-100 text-yellow-800
                            @endif">
                            {{ ucfirst($mtraProject->status) }}
                        </span>
                        @else
                        <p class="text-gray-500">Tidak ada data</p>
                        @endif
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Mitra</label>
                        <p class="text-gray-900">{{ $mtraProject->user ? $mtraProject->user->name : 'Tidak ada data' }}</p>
                    </div>
                </div>
            </div>

            <!-- Keterangan -->
            @if($mtraProject->keterangan)
            <div class="mb-8">
                <label class="block text-sm font-medium text-gray-700 mb-2">Keterangan</label>
                <div class="bg-gray-50 rounded-lg p-4">
                    <p class="text-gray-900">{{ $mtraProject->keterangan }}</p>
                </div>
            </div>
            @endif

            <!-- Photos -->
            @if($mtraProject->photos && $mtraProject->photos->count() > 0)
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-4">Foto Project ({{ $mtraProject->photos->count() }})</label>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    @foreach($mtraProject->photos as $photo)
                    <div class="relative group">
                        <img src="{{ $photo->path ? Storage::url($photo->path) : asset('images/placeholder.jpg') }}" 
                             alt="Project Photo" 
                             class="w-full h-32 object-cover rounded-lg border border-gray-200">
                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-50 transition-all duration-200 rounded-lg flex items-center justify-center">
                            <button onclick="openImageModal('{{ $photo->path ? Storage::url($photo->path) : asset('images/placeholder.jpg') }}')" 
                                    class="opacity-0 group-hover:opacity-100 transition-opacity duration-200 bg-white bg-opacity-90 p-2 rounded-full">
                                <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @else
            <div class="text-center py-8">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada foto</h3>
                <p class="text-gray-500">Project ini belum memiliki foto</p>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Image Modal -->
<div id="imageModal" class="fixed inset-0 bg-black bg-opacity-75 hidden z-50 flex items-center justify-center">
    <div class="relative max-w-4xl max-h-full p-4">
        <button onclick="closeImageModal()" class="absolute top-4 right-4 text-white hover:text-gray-300">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
        <img id="modalImage" src="" alt="Full size image" class="max-w-full max-h-full object-contain">
    </div>
</div>

<script>
function openImageModal(imageSrc) {
    document.getElementById('modalImage').src = imageSrc;
    document.getElementById('imageModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeImageModal() {
    document.getElementById('imageModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Close modal when clicking outside
document.getElementById('imageModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeImageModal();
    }
});
</script>
@endsection 