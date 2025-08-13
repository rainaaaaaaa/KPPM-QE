@extends('layouts.app')

@section('page-title', 'Project Mitra')

@section('content')

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Success/Error Messages -->
    @if(session('success'))
    <div class="mb-6">
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
    <div class="mb-6">
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

    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Project Mitra</h1>
                <p class="text-gray-600 mt-1">Kelola semua project Mitra Anda</p>
            </div>
            <a href="{{ route('mtra.create') }}" 
               class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-red-600 to-red-500 text-white rounded-lg hover:from-red-700 hover:to-red-600 transition-all duration-200 shadow-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Project
            </a>
        </div>
    </div>

    <!-- Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <div class="flex items-center">
                <div class="w-10 h-10 bg-gradient-to-br from-red-100 to-red-50 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-600">Total</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $mtraProjects->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <div class="flex items-center">
                <div class="w-10 h-10 bg-gradient-to-br from-green-100 to-green-50 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-600">Recovery</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $mtraProjects->where('jenis', 'recovery')->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <div class="flex items-center">
                <div class="w-10 h-10 bg-gradient-to-br from-yellow-100 to-yellow-50 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-600">Preventif</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $mtraProjects->where('jenis', 'preventif')->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <div class="flex items-center">
                <div class="w-10 h-10 bg-gradient-to-br from-purple-100 to-purple-50 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-600">Relokasi</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $mtraProjects->where('jenis', 'relokasi')->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Projects List -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Daftar Project</h2>
        </div>
        
        <div class="p-6">
            <form method="GET" class="mb-6 grid grid-cols-1 md:grid-cols-4 gap-4">
                <input type="text" name="nomor_kontrak" value="{{ request('nomor_kontrak') }}" placeholder="Cari Nomor Kontrak" class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500">
                <input type="text" name="lokasi" value="{{ request('lokasi') }}" placeholder="Cari Lokasi" class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500">
                <select name="jenis" class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500">
                    <option value="">Semua Jenis</option>
                    <option value="recovery" {{ request('jenis') == 'recovery' ? 'selected' : '' }}>Recovery</option>
                    <option value="preventif" {{ request('jenis') == 'preventif' ? 'selected' : '' }}>Preventif</option>
                    <option value="relokasi" {{ request('jenis') == 'relokasi' ? 'selected' : '' }}>Relokasi</option>
                </select>
                <select name="status" class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500">
                    <option value="">Semua Status</option>
                    <option value="planning" {{ request('status') == 'planning' ? 'selected' : '' }}>Planning</option>
                    <option value="berjalan" {{ request('status') == 'berjalan' ? 'selected' : '' }}>Berjalan</option>
                    <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                </select>
                <button type="submit" class="col-span-1 md:col-span-4 bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition">Cari</button>
            </form>
            @if($mtraProjects->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($mtraProjects as $project)
                    <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-lg p-6 hover:from-gray-100 hover:to-gray-200 transition-all duration-200 border border-gray-200">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex-1">
                                <h3 class="text-lg font-semibold text-gray-900 mb-1">{{ $project->nomor_kontrak }}</h3>
                                <p class="text-sm text-gray-600">{{ $project->lokasi }}</p>
                                <span class="inline-block mt-1 px-2 py-0.5 rounded text-xs font-semibold border
                                    @if($project->status == 'planning') bg-yellow-100 text-yellow-800 border-yellow-200
                                    @elseif($project->status == 'berjalan') bg-green-100 text-green-800 border-green-200
                                    @else bg-gray-200 text-gray-700 border-gray-300
                                    @endif">
                                    Status: {{ ucfirst($project->status) }}
                                </span>
                            </div>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                @if($project->jenis == 'recovery') bg-gradient-to-r from-green-100 to-green-50 text-green-800 border border-green-200
                                @elseif($project->jenis == 'preventif') bg-gradient-to-r from-yellow-100 to-yellow-50 text-yellow-800 border border-yellow-200
                                @else bg-gradient-to-r from-blue-100 to-blue-50 text-blue-800 border border-blue-200
                                @endif">
                                {{ ucfirst($project->jenis) }}
                            </span>
                        </div>
                        
                        @if($project->keterangan)
                        <div class="mb-4">
                            <p class="text-sm text-gray-700 line-clamp-2">{{ $project->keterangan }}</p>
                        </div>
                        @endif
                        
                        <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                            <span>{{ $project->created_at ? $project->created_at->format('d M Y') : 'N/A' }}</span>
                            @if($project->photos && $project->photos->count() > 0)
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                {{ $project->photos->count() }} foto
                            </span>
                            @endif
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <a href="{{ route('mtra.show', $project) }}" 
                               class="text-red-600 hover:text-red-800 font-medium text-sm">
                                Lihat Detail
                            </a>
                            <form action="{{ route('mtra.destroy', $project) }}" method="POST" class="inline" 
                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus project ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 text-sm">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <div class="w-16 h-16 bg-gradient-to-br from-gray-100 to-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada project</h3>
                    <p class="text-gray-500 mb-6">Mulai dengan menambahkan project pertama Anda</p>
                    <a href="{{ route('mtra.create') }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-red-600 to-red-500 text-white rounded-lg hover:from-red-700 hover:to-red-600 transition-all duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Tambah Project Pertama
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection 