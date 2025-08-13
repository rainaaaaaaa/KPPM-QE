@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Dokumen Proyek</h1>
                <p class="text-gray-600">Kelola dan review semua dokumen proyek mitra</p>
            </div>
            <a href="{{ route('ped.dashboard') }}" class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 transition-colors">
                Kembali ke Dashboard
            </a>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <form method="GET" action="{{ route('ped.index') }}" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
            <div>
                <label for="nomor_kontrak" class="block text-sm font-medium text-gray-700 mb-1">Nomor Kontrak</label>
                <input type="text" name="nomor_kontrak" id="nomor_kontrak" value="{{ request('nomor_kontrak') }}" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500">
            </div>
            
            <div>
                <label for="lokasi" class="block text-sm font-medium text-gray-700 mb-1">Lokasi</label>
                <input type="text" name="lokasi" id="lokasi" value="{{ request('lokasi') }}" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500">
            </div>
            
            <div>
                <label for="jenis" class="block text-sm font-medium text-gray-700 mb-1">Jenis Proyek</label>
                <select name="jenis" id="jenis" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500">
                    <option value="all">Semua Jenis</option>
                    <option value="recovery" {{ request('jenis') === 'recovery' ? 'selected' : '' }}>Recovery</option>
                    <option value="preventif" {{ request('jenis') === 'preventif' ? 'selected' : '' }}>Preventif</option>
                    <option value="corrective" {{ request('jenis') === 'corrective' ? 'selected' : '' }}>Corrective</option>
                </select>
            </div>
            
            <div>
                <label for="approval_status" class="block text-sm font-medium text-gray-700 mb-1">Status Approval</label>
                <select name="approval_status" id="approval_status" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('approval_status') === 'pending' ? 'selected' : '' }}>Menunggu Review</option>
                    <option value="approved" {{ request('approval_status') === 'approved' ? 'selected' : '' }}>Disetujui</option>
                    <option value="rejected" {{ request('approval_status') === 'rejected' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </div>
            
            <div class="flex items-end">
                <button type="submit" class="w-full px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition-colors">
                    Filter
                </button>
            </div>
        </form>
    </div>

    <!-- Projects List -->
    <div class="bg-white rounded-lg shadow-md">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-900">Daftar Proyek ({{ $projects->total() }})</h2>
        </div>
        
        <div class="p-6">
            @if($projects->count() > 0)
                <div class="space-y-4">
                    @foreach($projects as $project)
                    <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition-colors">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <div class="flex items-center space-x-3">
                                    <div class="flex-shrink-0">
                                        <div class="w-10 h-10 rounded-full flex items-center justify-center
                                            @if($project->ped_approved === null) bg-yellow-100
                                            @elseif($project->ped_approved === true) bg-green-100
                                            @else bg-red-100 @endif">
                                            @if($project->ped_approved === null)
                                                <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                            @elseif($project->ped_approved === true)
                                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                </svg>
                                            @else
                                                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                </svg>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900">
                                            {{ $project->nomor_kontrak }}
                                        </p>
                                        <p class="text-sm text-gray-500">
                                            {{ $project->lokasi }} - {{ $project->user->name }}
                                        </p>
                                        <div class="flex items-center space-x-2 mt-1">
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                                @if($project->jenis === 'recovery') bg-red-100 text-red-800
                                                @elseif($project->jenis === 'preventif') bg-yellow-100 text-yellow-800
                                                @else bg-green-100 text-green-800 @endif">
                                                {{ ucfirst($project->jenis) }}
                                            </span>
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
                                            <span class="text-xs text-gray-500">
                                                {{ $project->created_at->diffForHumans() }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('ped.show', $project) }}" 
                                   class="px-3 py-1 bg-red-600 text-white text-sm rounded-md hover:bg-red-700 transition-colors">
                                    Detail
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <!-- Pagination -->
                <div class="mt-6">
                    {{ $projects->links() }}
                </div>
            @else
                <div class="text-center py-8">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada proyek ditemukan</h3>
                    <p class="mt-1 text-sm text-gray-500">Coba ubah filter pencarian Anda.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
