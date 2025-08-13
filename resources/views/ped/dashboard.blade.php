@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Dashboard PED</h1>
        <p class="text-gray-600">Selamat datang di QE Deployment Mitra System</p>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Projects -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Total Proyek</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalProjects }}</p>
                </div>
            </div>
        </div>

        <!-- Pending Projects -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Menunggu Review</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $pendingCount }}</p>
                </div>
            </div>
        </div>

        <!-- Approved Projects -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Disetujui</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $approvedCount }}</p>
                </div>
            </div>
        </div>

        <!-- Rejected Projects -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Ditolak</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $rejectedCount }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Pending Projects Section -->
    <div class="bg-white rounded-lg shadow-md">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold text-gray-900">Proyek Menunggu Review</h2>
                <a href="{{ route('ped.index') }}" class="text-red-600 hover:text-red-800 text-sm font-medium">
                    Lihat Semua →
                </a>
            </div>
        </div>
        
        <div class="p-6">
            @if($pendingProjects->count() > 0)
                <div class="space-y-4">
                    @foreach($pendingProjects->take(5) as $project)
                    <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition-colors">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <div class="flex items-center space-x-3">
                                    <div class="flex-shrink-0">
                                        <div class="w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center">
                                            <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
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
                                    Review
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                @if($pendingProjects->count() > 5)
                <div class="mt-6 text-center">
                    <a href="{{ route('ped.index') }}" class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition-colors">
                        Lihat Semua Proyek ({{ $pendingProjects->count() }})
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
                @endif
            @else
                <div class="text-center py-8">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada proyek menunggu review</h3>
                    <p class="mt-1 text-sm text-gray-500">Semua proyek telah direview atau tidak ada proyek baru.</p>
                    <div class="mt-6">
                        <a href="{{ route('ped.index') }}" class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition-colors">
                            Lihat Semua Proyek
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Aksi Cepat</h3>
            <div class="space-y-3">
                <a href="{{ route('ped.index') }}" class="flex items-center p-3 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                    <svg class="w-5 h-5 mr-3 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    Lihat Semua Dokumen Proyek
                </a>
                <a href="{{ route('ped.notifications') }}" class="flex items-center p-3 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                    <svg class="w-5 h-5 mr-3 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM4.19 4.19A2 2 0 006 3h12a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V5a2 2 0 012-2z"/>
                    </svg>
                    Lihat Notifikasi
                </a>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Statistik Hari Ini</h3>
            <div class="space-y-3">
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Proyek Baru</span>
                    <span class="text-sm font-medium text-gray-900">{{ $pendingProjects->where('created_at', '>=', now()->startOfDay())->count() }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Total Review</span>
                    <span class="text-sm font-medium text-gray-900">{{ $approvedCount + $rejectedCount }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Tingkat Persetujuan</span>
                    <span class="text-sm font-medium text-gray-900">
                        @if($totalProjects > 0)
                            {{ round(($approvedCount / $totalProjects) * 100, 1) }}%
                        @else
                            0%
                        @endif
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
