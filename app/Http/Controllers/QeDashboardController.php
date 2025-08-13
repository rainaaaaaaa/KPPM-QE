<?php

namespace App\Http\Controllers;

use App\Models\MtraProject;
use Illuminate\Http\Request;

class QeDashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Redirect based on user role
        if ($user->isPed()) {
            return redirect()->route('ped.dashboard');
        }
        
        // Simple counts to avoid timeout
        $mtraProjects = MtraProject::count();
        $recoveryProjects = MtraProject::where('jenis', 'recovery')->count();
        $preventifProjects = MtraProject::where('jenis', 'preventif')->count();
        $relokasiProjects = MtraProject::where('jenis', 'relokasi')->count();
        
        // Get recent projects (limit to 3 to avoid timeout)
        $recentProjects = MtraProject::orderBy('created_at', 'desc')
            ->limit(3)
            ->get();

        return view('mtra.dashboard', compact(
            'mtraProjects',
            'recoveryProjects', 
            'preventifProjects',
            'relokasiProjects',
            'recentProjects'
        ));
    }
}
