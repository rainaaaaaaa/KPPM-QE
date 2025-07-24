@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto mt-8 bg-white p-6 rounded shadow">
    <h2 class="text-2xl font-bold mb-4 text-red-600">Upload Dokumen HEM</h2>
    @if ($errors->any())
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
            <label class="block mb-1 font-semibold text-gray-700">Nama Dokumen</label>
            <input type="text" name="nama_dokumen" class="w-full rounded border-gray-300 bg-white text-gray-900" required value="{{ old('nama_dokumen') }}">
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-semibold text-gray-700">Lokasi/Daerah</label>
            <select name="lokasi" class="w-full rounded border-gray-300 bg-white text-gray-900">
                <option value="">-- Pilih Lokasi --</option>
                @foreach($lokasiList as $lokasi)
                    <option value="{{ $lokasi }}" @if(old('lokasi')==$lokasi) selected @endif>{{ $lokasi }}</option>
                @endforeach
            </select>
            <input type="text" name="lokasi" placeholder="Atau ketik lokasi baru" class="w-full mt-2 rounded border-gray-300 bg-white text-gray-900" value="">
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-semibold text-gray-700">File Dokumen</label>
            <input type="file" name="file" class="w-full rounded border-gray-300 bg-white text-gray-900" required>
            <small class="text-gray-500">Format: pdf, doc, docx, ppt, pptx, xls, xlsx. Max 10MB</small>
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-semibold text-gray-700">Keterangan</label>
            <textarea name="keterangan" class="w-full rounded border-gray-300 bg-white text-gray-900">{{ old('keterangan') }}</textarea>
        </div>
        <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 font-bold shadow">Upload</button>
    </form>
</div>
@endsection 