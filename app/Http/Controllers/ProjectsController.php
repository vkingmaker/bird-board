<?php

namespace App\Http\Controllers;

use App\Project;

class ProjectsController extends Controller
{
    public function index()
    {
        $attributes = auth()->user()->projects;

        return view('projects.index', compact('attributes'));
    }

    public function store()
    {
        $attributes = request()->validate([
            'title' => 'required',
            'description' => 'required'
            ]);


        auth()->user()->projects()->create($attributes);

        return redirect('projects');
    }

    public function show(Project $project)
    {
        if(auth()->user()->isNot($project->owner))
        {
            abort(403);
        }

        return view('projects.show', compact('project'));
    }
}
