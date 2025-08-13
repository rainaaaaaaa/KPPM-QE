@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Detail Proyek</h1>
                <p class="text-gray-600">Review dan kelola dokumen proyek</p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('ped.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 transition-colors">
                    Kembali ke Daftar
                </a>
                <a href="{{ route('ped.dashboard') }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                    Dashboard
                </a>
                <button onclick="location.reload()" class="px-4 py-2 bg-yellow-600 text-white rounded-md hover:bg-yellow-700 transition-colors">
                    🔄 Refresh
                </button>
            </div>
        </div>
    </div>

    <!-- Success Message -->
    @if(session('success'))
    <div class="lg:col-span-3 mb-6">
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

    <!-- Project Details -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Project Information -->
            <div class="bg-white rounded-lg shadow-md">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-900">Informasi Proyek</h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Kontrak</label>
                            <p class="text-sm text-gray-900 font-medium">{{ $project->nomor_kontrak }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Lokasi</label>
                            <p class="text-sm text-gray-900">{{ $project->lokasi }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Proyek</label>
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                @if($project->jenis === 'recovery') bg-red-100 text-red-800
                                @elseif($project->jenis === 'preventif') bg-blue-100 text-blue-800
                                @else bg-green-100 text-green-800 @endif">
                                {{ ucfirst($project->jenis) }}
                            </span>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                @if($project->ped_approved === null) bg-yellow-100 text-yellow-800
                                @elseif($project->ped_approved === true) bg-green-100 text-green-800
                                @else bg-red-100 text-red-800 @endif">
                                @if($project->ped_approved === null)
                                    Menunggu Review
                                @elseif($project->ped_approved === true)
                                    Disetujui
                                @else
                                    Ditolak
                                @endif
                            </span>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Mitra</label>
                            <p class="text-sm text-gray-900">{{ $project->user->name }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Dibuat</label>
                            <p class="text-sm text-gray-900">{{ $project->created_at ? $project->created_at->format('d M Y H:i') : 'N/A' }}</p>
                        </div>
                        @if($project->ped_reviewed_at)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Review</label>
                            <p class="text-sm text-gray-900">{{ $project->ped_reviewed_at ? $project->ped_reviewed_at->format('d M Y H:i') : 'N/A' }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Project Photos -->
            @if($project->photos->count() > 0)
            <div class="bg-white rounded-lg shadow-md">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-900">Foto Dokumentasi ({{ $project->photos->count() }})</h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($project->photos as $photo)
                        <div class="relative group">
                            <img src="{{ asset('storage/' . $photo->path) }}" 
                                 alt="Project Photo" 
                                 class="w-full h-48 object-cover rounded-lg shadow-sm">
                            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-50 transition-all duration-200 rounded-lg flex items-center justify-center">
                                <a href="{{ asset('storage/' . $photo->path) }}" 
                                   target="_blank"
                                   class="opacity-0 group-hover:opacity-100 transition-opacity duration-200 bg-white bg-opacity-90 p-2 rounded-full">
                                    <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            <!-- PED Notes -->
            @if($project->ped_notes)
            <div class="bg-white rounded-lg shadow-md">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-900">Catatan PED</h2>
                </div>
                <div class="p-6">
                    <p class="text-sm text-gray-900 whitespace-pre-wrap">{{ $project->ped_notes }}</p>
                </div>
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Approval Actions -->
            @if($project->ped_approved === null)
            <div class="bg-white rounded-lg shadow-md">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-900">Review Proyek</h2>
                    <p class="text-sm text-gray-600 mt-1">Pilih salah satu aksi di bawah ini:</p>
                </div>
                <div class="p-6">
                    <!-- Notes Section -->
                    <div class="mb-6">
                        <label for="ped_notes" class="block text-sm font-medium text-gray-700 mb-2">Catatan (Opsional)</label>
                        <textarea name="ped_notes" id="ped_notes" rows="4" 
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                  placeholder="Tambahkan catatan review jika diperlukan..."></textarea>
                    </div>
                    
                    <!-- Approval Buttons -->
                    <div class="space-y-4">
                        <!-- Debug Info -->
                        <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded mb-4">
                            <strong>Debug:</strong> Status proyek: {{ $project->ped_approved === null ? 'Menunggu Review' : ($project->ped_approved ? 'Disetujui' : 'Ditolak') }}
                            <br><strong>Project ID:</strong> {{ $project->id }}
                            <br><strong>Raw Value:</strong> {{ var_export($project->ped_approved, true) }}
                            <br><strong>Last Updated:</strong> {{ $project->updated_at }}
                        </div>
                        
                        <!-- Approve Button -->
                        <form method="POST" action="{{ route('ped.approve.alt', $project) }}" class="w-full" id="approveForm">
                            @csrf
                            <textarea name="ped_notes" style="display: none;">{{ request('ped_notes', '') }}</textarea>
                            <button type="submit" 
                                    class="w-full px-6 py-4 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors font-semibold text-lg shadow-md border-0"
                                    style="background: linear-gradient(135deg, #059669 0%, #10b981 100%) !important; color: white !important; font-size: 18px !important; font-weight: bold !important; box-shadow: 0 4px 6px rgba(5, 150, 105, 0.3) !important;"
                                    onclick="this.form.querySelector('textarea[name=ped_notes]').value = document.getElementById('ped_notes').value;">
                                <svg class="w-6 h-6 mr-3 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                ✅ SETUJUI PROYEK (ALT ROUTE)
                            </button>
                        </form>
                        
                        <!-- Reject Button -->
                        <form method="POST" action="{{ route('ped.reject.alt', $project) }}" class="w-full" id="rejectForm">
                            @csrf
                            <textarea name="ped_notes" style="display: none;">{{ request('ped_notes', '') }}</textarea>
                            <button type="submit" 
                                    class="w-full px-6 py-4 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors font-semibold text-lg shadow-md border-0"
                                    style="background: linear-gradient(135deg, #dc2626 0%, #ef4444 100%) !important; color: white !important; font-size: 18px !important; font-weight: bold !important; box-shadow: 0 4px 6px rgba(220, 38, 38, 0.3) !important;"
                                    onclick="this.form.querySelector('textarea[name=ped_notes]').value = document.getElementById('ped_notes').value; return confirm('Apakah Anda yakin ingin menolak proyek ini?')">
                                <svg class="w-6 h-6 mr-3 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                ❌ TOLAK PROYEK (ALT ROUTE)
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @else
            <!-- Review Status -->
            <div class="bg-white rounded-lg shadow-md">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-900">Status Review</h2>
                </div>
                <div class="p-6">
                    <div class="text-center">
                        @if($project->ped_approved === true)
                            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-green-800 mb-2">Proyek Disetujui</h3>
                        @else
                            <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-red-800 mb-2">Proyek Ditolak</h3>
                        @endif
                        <p class="text-sm text-gray-600">
                            Direview pada {{ $project->ped_reviewed_at ? $project->ped_reviewed_at->format('d M Y H:i') : 'N/A' }}
                        </p>
                    </div>
                </div>
            </div>
            @endif

            <!-- Project Statistics -->
            <div class="bg-white rounded-lg shadow-md">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-900">Statistik</h2>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Jumlah Foto</span>
                        <span class="text-sm font-medium text-gray-900">{{ $project->photos->count() }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Durasi Proyek</span>
                        <span class="text-sm font-medium text-gray-900">{{ $project->created_at ? $project->created_at->diffForHumans() : 'N/A' }}</span>
                    </div>
                    @if($project->ped_reviewed_at)
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Waktu Review</span>
                        <span class="text-sm font-medium text-gray-900">{{ $project->created_at && $project->ped_reviewed_at ? $project->created_at->diffInDays($project->ped_reviewed_at) : 'N/A' }} hari</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
