<?php

namespace App\Http\Controllers;


use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function index()
    {
        return Auth::user()->projects()->with('tasks')->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);

        $project = Auth::user()->projects()->create($validated);

        return response()->json($project, 201);
    }

    public function show(Project $project)
    {
        $this->authorizeProject($project);
        return $project->load('tasks');
    }

    public function update(Request $request, Project $project)
    {
        $this->authorizeProject($project);

        $project->update($request->only('title', 'description'));

        return response()->json($project);
    }

    public function destroy(Project $project)
    {
        $this->authorizeProject($project);

        $project->delete();

        return response()->json(['message' => 'Deleted successfully']);
    }

    private function authorizeProject(Project $project)
    {
        if ($project->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }
    }
}
