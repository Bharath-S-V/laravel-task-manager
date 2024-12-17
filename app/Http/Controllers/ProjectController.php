<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::all();
        return view('projects.index', compact('projects'));
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required']);
        Project::create($request->all());
        return redirect()->back();
    }
}


