<?php

namespace App\Http\Controllers;


use App\Models\Task;
use App\Models\Project;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function store(Request $request, Project $project)
    {
        $this->authorizeProject($project);

        $validated = $request->validate([
            'title' => 'required|string|max:255'
        ]);

        $task = $project->tasks()->create($validated);

        return response()->json($task, 201);
    }

    public function update(Request $request, Project $project, Task $task)
    {
        $this->authorizeProject($project);

        $task->update($request->only('title', 'is_done'));

        return response()->json($task);
    }

    public function destroy(Project $project, Task $task)
    {
        $this->authorizeProject($project);

        $task->delete();

        return response()->json(['message' => 'Deleted successfully']);
    }

    private function authorizeProject(Project $project)
    {
        if ($project->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }
    }
}
