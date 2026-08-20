<?php

namespace App\Http\Controllers;

use App\Models\Project;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::published()->orderByDesc('completed_year')->paginate(9);

        return view('projects.index', ['projects' => $projects]);
    }

    public function show(Project $project)
    {
        abort_unless($project->status === Project::STATUS_PUBLISHED, 404);

        return view('projects.show', ['project' => $project]);
    }
}
