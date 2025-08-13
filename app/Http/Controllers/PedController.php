<?php

namespace App\Http\Controllers;

use App\Models\MtraProject;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PedController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        
        if (!$user->isPed()) {
            return redirect()->route('mtra.dashboard')->with('error', 'Akses ditolak!');
        }

        // Get pending projects for review
        $pendingProjects = MtraProject::with('user', 'photos')
            ->whereNull('ped_approved')
            ->orderBy('created_at', 'desc')
            ->get();

        // Get statistics
        $totalProjects = MtraProject::count();
        $pendingCount = MtraProject::whereNull('ped_approved')->count();
        $approvedCount = MtraProject::where('ped_approved', true)->count();
        $rejectedCount = MtraProject::where('ped_approved', false)->count();

        return view('ped.dashboard', compact('pendingProjects', 'totalProjects', 'pendingCount', 'approvedCount', 'rejectedCount'));
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        
        if (!$user->isPed()) {
            return redirect()->route('mtra.dashboard')->with('error', 'Akses ditolak!');
        }

        $query = MtraProject::with('user', 'photos');
        
        // Filter by nomor kontrak
        if ($request->filled('nomor_kontrak')) {
            $query->where('nomor_kontrak', 'like', '%' . $request->nomor_kontrak . '%');
        }
        
        // Filter by lokasi
        if ($request->filled('lokasi')) {
            $query->where('lokasi', 'like', '%' . $request->lokasi . '%');
        }
        
        // Filter by jenis proyek
        if ($request->filled('jenis') && $request->jenis !== 'all') {
            $query->where('jenis', $request->jenis);
        }
        
        // Filter by status planning
        if ($request->filled('status_planning')) {
            $query->where('status', $request->status_planning);
        }
        
        // Filter by approval status
        if ($request->filled('approval_status')) {
            if ($request->approval_status === 'pending') {
                $query->whereNull('ped_approved');
            } elseif ($request->approval_status === 'approved') {
                $query->where('ped_approved', true);
            } elseif ($request->approval_status === 'rejected') {
                $query->where('ped_approved', false);
            }
        }

        $projects = $query->orderBy('created_at', 'desc')->paginate(10);
        
        return view('ped.index', compact('projects'));
    }

    public function show(MtraProject $project)
    {
        $user = Auth::user();
        
        if (!$user->isPed()) {
            return redirect()->route('mtra.dashboard')->with('error', 'Akses ditolak!');
        }

        $project->load('photos', 'user');
        
        return view('ped.show', compact('project'));
    }

    public function approve(Request $request, MtraProject $project)
    {
        $user = Auth::user();
        
        if (!$user->isPed()) {
            return redirect()->route('mtra.dashboard')->with('error', 'Akses ditolak!');
        }

        // Debug info
        \Log::info('PED Approve called', [
            'project_id' => $project->id,
            'user_id' => $user->id,
            'ped_notes' => $request->ped_notes,
            'request_all' => $request->all()
        ]);

        $request->validate([
            'ped_notes' => 'nullable|string|max:1000',
        ]);

        // Force update with fresh data
        $project->ped_approved = true;
        $project->ped_reviewed_at = now();
        $project->ped_notes = $request->ped_notes ?? '';
        $project->status = 'berjalan';
        $project->save();

        \Log::info('PED Approve completed', [
            'project_id' => $project->id,
            'ped_approved' => $project->ped_approved,
            'ped_notes' => $project->ped_notes
        ]);

        return redirect()->route('ped.show', $project)->with('success', 'Proyek berhasil disetujui!');
    }

    public function reject(Request $request, MtraProject $project)
    {
        $user = Auth::user();
        
        if (!$user->isPed()) {
            return redirect()->route('mtra.dashboard')->with('error', 'Akses ditolak!');
        }

        $request->validate([
            'ped_notes' => 'nullable|string|max:1000',
        ]);

        $project->update([
            'ped_approved' => false,
            'ped_reviewed_at' => now(),
            'ped_notes' => $request->ped_notes ?? '',
        ]);

        return redirect()->route('ped.show', $project)->with('success', 'Proyek berhasil ditolak!');
    }

    public function notifications()
    {
        $user = Auth::user();
        
        if (!$user->isPed()) {
            return redirect()->route('mtra.dashboard')->with('error', 'Akses ditolak!');
        }

        // Get recent projects that need review
        $recentProjects = MtraProject::with('user')
            ->whereNull('ped_approved')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('ped.notifications', compact('recentProjects'));
    }
}
