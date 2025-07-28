@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto mt-8 bg-white p-6 rounded shadow">
    <h2 class="text-2xl font-bold mb-4 text-red-600">Upload Dokumen QE</h2>
    @if ($errors->any())
        <div class="mb-4 text-red-600">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form method="POST" action="{{ route('qe.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="mb-4">
            <label class="block mb-1 font-semibold text-gray-700">Nama Dokumen</label>
            <input type="text" name="nama_dokumen" class="w-full rounded border-gray-300 bg-white text-gray-900" required value="{{ old('nama_dokumen') }}">
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-semibold text-gray-700">Lokasi/Daerah</label>
            <div class="space-y-2">
                <!-- Dropdown untuk lokasi yang sudah ada -->
                <select id="lokasi-dropdown" name="lokasi" class="w-full rounded border-gray-300 bg-white text-gray-900">
                    <option value="">-- Pilih Lokasi yang Sudah Ada --</option>
                    @foreach($lokasiList as $lokasi)
                        <option value="{{ $lokasi }}" @if(old('lokasi')==$lokasi) selected @endif>{{ $lokasi }}</option>
                    @endforeach
                </select>
                
                <!-- Input untuk lokasi baru -->
                <div class="flex items-center space-x-2">
                    <input type="text" id="lokasi-input" name="lokasi_new" placeholder="Atau ketik lokasi baru" class="w-full rounded border-gray-300 bg-white text-gray-900" value="{{ old('lokasi_new') }}">
                    <button type="button" id="toggle-lokasi" class="px-3 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 text-sm">
                        Lokasi Baru
                    </button>
                </div>
                
                <p class="text-xs text-gray-500">
                    💡 Pilih lokasi yang sudah ada dari dropdown, atau klik "Lokasi Baru" untuk menambah lokasi baru
                </p>
            </div>
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const dropdown = document.getElementById('lokasi-dropdown');
    const input = document.getElementById('lokasi-input');
    const toggleBtn = document.getElementById('toggle-lokasi');
    let isNewLocation = false;

    // Toggle antara dropdown dan input
    toggleBtn.addEventListener('click', function() {
        if (isNewLocation) {
            // Switch ke dropdown
            dropdown.style.display = 'block';
            input.style.display = 'none';
            input.value = '';
            toggleBtn.textContent = 'Lokasi Baru';
            toggleBtn.className = 'px-3 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 text-sm';
            isNewLocation = false;
        } else {
            // Switch ke input
            dropdown.style.display = 'none';
            input.style.display = 'block';
            dropdown.value = '';
            toggleBtn.textContent = 'Pilih Lokasi';
            toggleBtn.className = 'px-3 py-2 bg-blue-200 text-blue-700 rounded hover:bg-blue-300 text-sm';
            isNewLocation = true;
        }
    });

    // Ketika dropdown dipilih, disable input
    dropdown.addEventListener('change', function() {
        if (this.value) {
            input.value = '';
        }
    });

    // Ketika input diketik, disable dropdown
    input.addEventListener('input', function() {
        if (this.value) {
            dropdown.value = '';
        }
    });
});
</script>
@endsection 