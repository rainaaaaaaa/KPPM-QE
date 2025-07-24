@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto mt-8 bg-white dark:bg-gray-800 p-6 rounded shadow">
    <h2 class="text-2xl font-bold mb-4 text-primary">Upload Dokumen HEM</h2>
    @if (
$errors->any())
        <div class="mb-4 text-red-600">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form method="POST" action="{{ route('hem.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Nama Dokumen</label>
            <input type="text" name="nama_dokumen" class="w-full rounded border-gray-300 dark:bg-gray-900 dark:text-white" required value="{{ old('nama_dokumen') }}">
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Lokasi/Daerah</label>
            <select name="lokasi" class="w-full rounded border-gray-300 dark:bg-gray-900 dark:text-white">
                <option value="">-- Pilih Lokasi --</option>
                @foreach($lokasiList as $lokasi)
                    <option value="{{ $lokasi }}" @if(old('lokasi')==$lokasi) selected @endif>{{ $lokasi }}</option>
                @endforeach
            </select>
            <input type="text" name="lokasi" placeholder="Atau ketik lokasi baru" class="w-full mt-2 rounded border-gray-300 dark:bg-gray-900 dark:text-white" value="">
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-semibold">File Dokumen</label>
            <input type="file" name="file" class="w-full rounded border-gray-300 dark:bg-gray-900 dark:text-white" required>
            <small class="text-gray-500">Format: pdf, doc, docx, ppt, pptx, xls, xlsx. Max 10MB</small>
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Keterangan</label>
            <textarea name="keterangan" class="w-full rounded border-gray-300 dark:bg-gray-900 dark:text-white">{{ old('keterangan') }}</textarea>
        </div>
        <button type="submit" class="bg-primary text-white px-4 py-2 rounded hover:bg-primary-dark">Upload</button>
    </form>
</div>
@endsection 