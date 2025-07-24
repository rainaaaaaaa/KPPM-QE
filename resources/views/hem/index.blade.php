@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto mt-8 bg-white dark:bg-gray-800 p-6 rounded shadow">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-bold text-primary">Daftar Dokumen HEM</h2>
        <a href="{{ route('hem.create') }}" class="bg-primary text-white px-4 py-2 rounded hover:bg-primary-dark">Upload Baru</a>
    </div>
    <form method="GET" action="" class="mb-4 flex items-center gap-2">
        <label for="lokasi" class="font-semibold">Filter Lokasi:</label>
        <select name="lokasi" id="lokasi" class="rounded border-gray-300 dark:bg-gray-900 dark:text-white" onchange="this.form.submit()">
            <option value="">Semua Lokasi</option>
            @foreach($lokasiList as $lokasi)
                <option value="{{ $lokasi }}" @if(request('lokasi')==$lokasi) selected @endif>{{ $lokasi }}</option>
            @endforeach
        </select>
    </form>
    @if(session('success'))
        <div class="mb-4 text-green-600">{{ session('success') }}</div>
    @endif
    <table class="min-w-full table-auto border dark:border-gray-700">
        <thead>
            <tr class="bg-gray-100 dark:bg-gray-900">
                <th class="px-4 py-2">Nama Dokumen</th>
                <th class="px-4 py-2">Lokasi</th>
                <th class="px-4 py-2">File</th>
                <th class="px-4 py-2">Keterangan</th>
                <th class="px-4 py-2">User</th>
                <th class="px-4 py-2">Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @forelse($documents as $doc)
            <tr>
                <td class="border px-4 py-2 dark:border-gray-700">{{ $doc->nama_dokumen }}</td>
                <td class="border px-4 py-2 dark:border-gray-700">{{ $doc->lokasi }}</td>
                <td class="border px-4 py-2 dark:border-gray-700">
                    <a href="{{ asset('storage/'.$doc->file_path) }}" target="_blank" class="text-primary underline">Download</a>
                </td>
                <td class="border px-4 py-2 dark:border-gray-700">{{ $doc->keterangan }}</td>
                <td class="border px-4 py-2 dark:border-gray-700">{{ $doc->user->name ?? '-' }}</td>
                <td class="border px-4 py-2 dark:border-gray-700">{{ $doc->created_at->format('d-m-Y H:i') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center py-4">Belum ada dokumen.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection 