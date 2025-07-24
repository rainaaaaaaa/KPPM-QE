<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HemDocumentController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
    {
        $lokasiList = \App\Models\HemDocument::select('lokasi')->distinct()->pluck('lokasi');
        $query = \App\Models\HemDocument::query();
        if ($request->filled('lokasi')) {
            $query->where('lokasi', $request->lokasi);
        }
        $documents = $query->orderBy('created_at', 'desc')->get();
        return view('hem.index', compact('documents', 'lokasiList'));
    }

    public function create()
    {
        // Ambil lokasi unik dari dokumen yang sudah ada untuk dropdown
        $lokasiList = \App\Models\HemDocument::select('lokasi')->distinct()->pluck('lokasi');
        return view('hem.create', compact('lokasiList'));
    }

    public function store(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'nama_dokumen' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'file' => 'required|mimes:pdf,doc,docx,ppt,pptx,xls,xlsx|max:10240',
            'keterangan' => 'nullable|string',
        ]);

        $filePath = $request->file('file')->store('hem_documents', 'public');

        $doc = new \App\Models\HemDocument();
        $doc->nama_dokumen = $request->nama_dokumen;
        $doc->lokasi = $request->lokasi;
        $doc->file_path = $filePath;
        $doc->keterangan = $request->keterangan;
        $doc->user_id = auth()->id();
        $doc->save();

        return redirect()->route('hem.index')->with('success', 'Dokumen berhasil diupload!');
    }
}
