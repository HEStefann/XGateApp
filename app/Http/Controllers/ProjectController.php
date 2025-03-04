<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ProjectController extends Controller
{
    public function index()
    {
        return Auth::user()->projects;
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required', 'description' => 'required']);
        return Auth::user()->projects()->create($request->all());

    }

    public function update(Request $request, Project $project)
    {
        if ($project->user_id !== Auth::user()->id) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        
        $request->validate(['name' => 'required']);

        $project->update($request->all());
        return $project;
    }

    public function destroy(Project $project)
    {
        if ($project->user_id !== Auth::user()->id) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $project->delete();
        return response()->json(['message' => 'Project deleted']);
    }
}
