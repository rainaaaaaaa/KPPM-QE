<?php

namespace App\Http\Controllers;

use App\Models\MtraProject;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function testProject()
    {
        $project = MtraProject::find(7);
        $project->load('user');
        
        return view('test', compact('project'));
    }
}
