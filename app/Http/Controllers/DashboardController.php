<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HemDocument;
use App\Models\QeDocument;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil data statistik dari database
        $hemDocuments = HemDocument::count();
        $qeDocuments = QeDocument::count();
        $totalDocuments = $hemDocuments + $qeDocuments;
        $recentDocuments = HemDocument::latest()->take(5)->get();
        
 // Pertumbuhan HEM
        $lastMonthHemCount = HemDocument::where('created_at', '>=', now()->subMonth())->count();
        $hemGrowthPercentage = $lastMonthHemCount > 0
            ? round((($hemDocuments - $lastMonthHemCount) / $lastMonthHemCount) * 100)
            : 0;

        // Pertumbuhan QE
        $lastMonthQeCount = QeDocument::where('created_at', '>=', now()->subMonth())->count();
        $qeGrowthPercentage = $lastMonthQeCount > 0
            ? round((($qeDocuments - $lastMonthQeCount) / $lastMonthQeCount) * 100)
            : 0;
        
        // Data untuk QE dan INDIHOME (placeholder untuk sekarang)
        $indihomeDocuments = 0; // Akan diisi ketika ada model INDIHOME
        
        // Aktivitas terbaru
             // Ambil 5 aktivitas HEM terakhir
        $hemActivities = HemDocument::with('user')
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($doc) {
                return [
                    'type' => 'HEM',
                    'message' => "Dokumen {$doc->nama_dokumen} diupload",
                    'time' => $doc->created_at->diffForHumans(),
                    'color' => 'green'
                ];
            });

        // Ambil 5 aktivitas QE terakhir
        $qeActivities = QeDocument::with('user')
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($doc) {
                return [
                    'type' => 'QE',
                    'message' => "Dokumen {$doc->nama_dokumen} diupload",
                    'time' => $doc->created_at->diffForHumans(),
                    'color' => 'blue'
                ];
            });

        // Gabungkan dan ambil 5 terbaru dari keduanya
        $recentActivities = collect($hemActivities)
            ->merge($qeActivities)
            ->sortByDesc('time')
            ->take(5)
            ->values();

          return view('dashboard', compact(
            'totalDocuments',
            'hemDocuments',
            'qeDocuments',
            'indihomeDocuments',
            'hemGrowthPercentage',
            'qeGrowthPercentage',
            'recentActivities'
        ));
    }
} 