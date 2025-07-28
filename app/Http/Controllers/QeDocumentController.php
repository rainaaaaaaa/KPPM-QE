<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class QeDocumentController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
    {
        $lokasiList = \App\Models\QeDocument::select('lokasi')->distinct()->pluck('lokasi');
        $query = \App\Models\QeDocument::query();
        if ($request->filled('lokasi')) {
            $query->where('lokasi', $request->lokasi);
        }
        $documents = $query->orderBy('created_at', 'desc')->get();
        return view('qe.index', compact('documents', 'lokasiList'));
    }

    public function create()
    {
        // Ambil lokasi unik dari dokumen yang sudah ada untuk dropdown
        $lokasiList = \App\Models\QeDocument::select('lokasi')->distinct()->pluck('lokasi');
        return view('qe.create', compact('lokasiList'));
    }

    public function store(\Illuminate\Http\Request $request)
    {
        // Tentukan lokasi yang akan digunakan
        $lokasi = $request->lokasi ?: $request->lokasi_new;
        
        $request->validate([
            'nama_dokumen' => 'required|string|max:255',
            'file' => 'required|mimes:pdf,doc,docx,ppt,pptx,xls,xlsx|max:10240',
            'keterangan' => 'nullable|string',
        ]);

        // Validasi lokasi
        if (empty($lokasi)) {
            return back()->withErrors(['lokasi' => 'Lokasi harus diisi. Pilih dari dropdown atau ketik lokasi baru.'])->withInput();
        }

        $filePath = $request->file('file')->store('qe_documents', 'public');

        $doc = new \App\Models\QeDocument();
        $doc->nama_dokumen = $request->nama_dokumen;
        $doc->lokasi = $lokasi;
        $doc->file_path = $filePath;
        $doc->keterangan = $request->keterangan;
        $doc->user_id = auth()->id();
        $doc->save();

        return redirect()->route('qe.index')->with('success', 'Dokumen berhasil diupload!');
    }
}
