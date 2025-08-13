@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Notifikasi</h1>
                <p class="text-gray-600">Notifikasi terbaru dari mitra</p>
            </div>
            <a href="{{ route('ped.dashboard') }}" class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 transition-colors">
                Kembali ke Dashboard
            </a>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-900">Proyek Terbaru Menunggu Review</h2>
        </div>
        <div class="p-6">
            @if($recentProjects->count() > 0)
                <div class="space-y-4">
                    @foreach($recentProjects as $project)
                    <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition-colors">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <div class="flex items-center space-x-3">
                                    <div class="flex-shrink-0">
                                        <div class="w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center">
                                            <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900">
                                            Proyek baru dari {{ $project->user->name }}
                                        </p>
                                        <p class="text-sm text-gray-500">
                                            {{ $project->nomor_kontrak }} - {{ $project->lokasi }}
                                        </p>
                                        <div class="flex items-center space-x-2 mt-1">
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                                @if($project->jenis === 'recovery') bg-red-100 text-red-800
                                                @elseif($project->jenis === 'preventif') bg-blue-100 text-blue-800
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
                                   class="px-3 py-1 bg-blue-600 text-white text-sm rounded-md hover:bg-blue-700 transition-colors">
                                    Review
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <div class="mt-6 text-center">
                    <a href="{{ route('ped.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                        Lihat Semua Proyek
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            @else
                <div class="text-center py-8">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM4.19 4.19A2 2 0 006 3h12a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V5a2 2 0 012-2z"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada notifikasi baru</h3>
                    <p class="mt-1 text-sm text-gray-500">Semua proyek telah direview atau tidak ada proyek baru.</p>
                    <div class="mt-6">
                        <a href="{{ route('ped.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                            Lihat Semua Proyek
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
