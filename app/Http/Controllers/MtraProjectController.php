<?php

namespace App\Http\Controllers;

use App\Models\MtraProject;
use App\Models\MtraPhoto;
use Illuminate\Http\Request;

class MtraProjectController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        
        // Start with base query
        $query = MtraProject::with('user', 'photos');
        
        // If user is not PED, only show their own projects
        if (!$user->isPed()) {
            $query->where('user_id', $user->id);
        }
        
        if ($request->filled('nomor_kontrak')) {
            $query->where('nomor_kontrak', 'like', '%' . $request->nomor_kontrak . '%');
        }
        if ($request->filled('lokasi')) {
            $query->where('lokasi', 'like', '%' . $request->lokasi . '%');
        }
        if ($request->filled('jenis')) {
            $query->where('jenis', $request->jenis);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        $mtraProjects = $query->orderBy('created_at', 'desc')->get();
        return view('mtra.index', compact('mtraProjects'));
    }

    public function create()
    {
        return view('mtra.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nomor_kontrak' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'jenis' => 'required|in:recovery,preventif,relokasi',
            'photos.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'keterangan' => 'nullable|string',
            'status' => 'required|in:planning,berjalan,selesai',
        ]);

        $data = [
            'nomor_kontrak' => $request->nomor_kontrak,
            'lokasi' => $request->lokasi,
            'jenis' => $request->jenis,
            'keterangan' => $request->keterangan ?: null,
            'user_id' => auth()->id(),
            'status' => $request->status,
        ];

        $project = MtraProject::create($data);

        // Handle multiple photos
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                if ($photo->isValid()) {
                    $photoPath = $photo->store('mitra_photos', 'public');
                    MtraPhoto::create([
                        'mtra_project_id' => $project->id,
                        'path' => $photoPath,
                    ]);
                }
            }
        }

        return redirect()->route('mtra.index')->with('success', 'Project Mitra berhasil ditambahkan! Menunggu review dari PED.');
    }

    public function show(MtraProject $mtra)
    {
        $user = auth()->user();
        
        // If user is not PED, check if they own this project
        if (!$user->isPed() && $mtra->user_id !== $user->id) {
            return redirect()->route('mtra.index')->with('error', 'Anda tidak memiliki izin untuk melihat proyek ini!');
        }

        $mtraProject = $mtra->load('photos', 'user');
        
        return view('mtra.show', compact('mtraProject'));
    }

    public function destroy(MtraProject $mtraProject)
    {
        $user = auth()->user();
        
        // Debug info
        \Log::info('Destroy attempt', [
            'project_id' => $mtraProject->id,
            'project_user_id' => $mtraProject->user_id,
            'current_user_id' => $user->id,
            'user_role' => $user->role,
            'ped_approved' => $mtraProject->ped_approved,
            'status' => $mtraProject->status
        ]);

        // Temporary fix: If project has no user_id, assign it to current user
        if (empty($mtraProject->user_id)) {
            $mtraProject->user_id = $user->id;
            $mtraProject->save();
            \Log::info('Fixed orphaned project', [
                'project_id' => $mtraProject->id,
                'assigned_to_user' => $user->id
            ]);
        }

        // If user is not PED, check if they own this project
        if (!$user->isPed() && $mtraProject->user_id !== $user->id) {
            \Log::warning('Authorization failed - user does not own project', [
                'project_id' => $mtraProject->id,
                'project_user_id' => $mtraProject->user_id,
                'current_user_id' => $user->id,
                'user_role' => $user->role
            ]);
            return redirect()->route('mtra.index')->with('error', 'Anda tidak memiliki izin untuk menghapus proyek ini! (Project ID: ' . $mtraProject->id . ', Your ID: ' . $user->id . ', Project Owner: ' . $mtraProject->user_id . ')');
        }

        // Allow deletion for all projects (removed PED approval restriction)
        try {
            // Delete all photos
            foreach ($mtraProject->photos as $photo) {
                if ($photo->path) {
                    \Storage::disk('public')->delete($photo->path);
                }
            }
            
            $mtraProject->delete();

            \Log::info('Project deleted successfully', [
                'project_id' => $mtraProject->id,
                'user_id' => $user->id,
                'user_role' => $user->role
            ]);

            return redirect()->route('mtra.index')->with('success', 'Project Mitra berhasil dihapus!');
        } catch (\Exception $e) {
            \Log::error('Failed to delete project', [
                'project_id' => $mtraProject->id,
                'error' => $e->getMessage()
            ]);
            return redirect()->route('mtra.index')->with('error', 'Gagal menghapus proyek. Error: ' . $e->getMessage());
        }
    }

    public function deletePhoto($photoId)
    {
        $photo = MtraPhoto::with('mtraProject')->findOrFail($photoId);
        
        // Check if user owns this project
        if ($photo->mtraProject->user_id !== auth()->id()) {
            return response()->json(['success' => false, 'message' => 'Anda tidak memiliki izin untuk menghapus foto ini!'], 403);
        }

        try {
            if ($photo->path) {
                \Storage::disk('public')->delete($photo->path);
            }
            $photo->delete();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal menghapus foto.'], 500);
        }
    }
}
