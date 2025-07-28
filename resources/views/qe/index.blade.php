@extends('layouts.app')

@section('content')
<div class="flex justify-center items-center min-h-screen pb-12 bg-gradient-to-br from-white via-red-50 to-white">
    <div class="max-w-2xl mx-auto mt-8 bg-white p-6 rounded shadow">
        <div class="flex justify-between items-center mb-8">
            <div class="flex items-center gap-3">
                <span class="text-3xl text-red-600"><svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='currentColor' class='w-8 h-8'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M7 7V3a1 1 0 011-1h8a1 1 0 011 1v4M7 7h10M7 7v14a1 1 0 001 1h8a1 1 0 001-1V7M7 7h10' /></svg></span>
                <h2 class="text-2xl font-bold text-red-600 tracking-tight">Daftar Dokumen QE</h2>
            </div>
            <a href="{{ route('qe.create') }}"
               class="px-7 py-3 rounded-xl font-bold text-red-600 bg-white border-2 border-red-500 shadow-lg flex items-center gap-2 hover:bg-gradient-to-r hover:from-red-600 hover:to-red-400 hover:text-white hover:border-red-600 transition-all duration-200">
                <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='currentColor' class='w-5 h-5'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M12 4v16m8-8H4'/></svg>
                Upload Baru
            </a>
        </div>
        <form method="GET" action="" class="mb-6 flex items-center gap-3">
            <label for="lokasi" class="font-semibold text-gray-700">Filter Lokasi:</label>
            <select name="lokasi" id="lokasi" class="rounded border-gray-300 px-3 py-2 focus:ring-red-500 focus:border-red-500" onchange="this.form.submit()">
                <option value="">Semua Lokasi</option>
                @foreach($lokasiList as $lokasi)
                    <option value="{{ $lokasi }}" @if(request('lokasi')==$lokasi) selected @endif>{{ $lokasi }}</option>
                @endforeach
            </select>
        </form>
        @if(session('success'))
            <div class="mb-6 flex items-center gap-2 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg shadow">
                <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='currentColor' class='w-5 h-5'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M5 13l4 4L19 7'/></svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif
        <div class="overflow-x-auto rounded-lg mt-2">
            <table class="min-w-full table-auto border border-gray-200 bg-white text-base font-sans">
                <thead class="sticky top-0 z-10 shadow-sm">
                    <tr class="bg-gradient-to-r from-red-100 to-red-50">
                        <th class="px-5 py-4 text-left text-gray-700 font-extrabold text-lg">Nama Dokumen</th>
                        <th class="px-5 py-4 text-left text-gray-700 font-extrabold text-lg">Lokasi</th>
                        <th class="px-5 py-4 text-left text-gray-700 font-extrabold text-lg">File</th>
                        <th class="px-5 py-4 text-left text-gray-700 font-extrabold text-lg">Keterangan</th>
                        <th class="px-5 py-4 text-left text-gray-700 font-extrabold text-lg">User</th>
                        <th class="px-5 py-4 text-left text-gray-700 font-extrabold text-lg">Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($documents as $doc)
                    <tr class="even:bg-gray-50 hover:bg-red-50 hover:shadow-lg transition-all duration-150">
                        <td class="border-t px-5 py-4 border-gray-200 text-base">{{ $doc->nama_dokumen }}</td>
                        <td class="border-t px-5 py-4 border-gray-200 text-base">{{ $doc->lokasi }}</td>
                        <td class="border-t px-5 py-4 border-gray-200">
                            <a href="{{ asset('storage/'.$doc->file_path) }}" target="_blank" class="text-red-600 underline font-semibold flex items-center gap-1 hover:text-red-800 transition-all duration-150">
                                <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='currentColor' class='w-5 h-5'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5m0 0l5-5m-5 5V4'/></svg>
                                Download
                            </a>
                        </td>
                        <td class="border-t px-5 py-4 border-gray-200 text-base">{{ $doc->keterangan }}</td>
                        <td class="border-t px-5 py-4 border-gray-200 text-base">{{ $doc->user->name ?? '-' }}</td>
                        <td class="border-t px-5 py-4 border-gray-200 text-base">{{ $doc->created_at->format('d-m-Y H:i') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-10 text-gray-400 text-lg">Belum ada dokumen.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection 