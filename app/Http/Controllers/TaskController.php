<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Project;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $projects = Project::all();
        $tasks = Task::orderBy('priority')->get();
        return view('tasks.index', compact('tasks', 'projects'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'project_id' => 'required|exists:projects,id'
        ]);

        $priority = Task::where('project_id', $request->project_id)->max('priority') + 1;

        Task::create([
            'name' => $request->name,
            'project_id' => $request->project_id,
            'priority' => $priority
        ]);

        return redirect()->back();
    }

    public function update(Request $request, Task $task)
    {
        $request->validate(['name' => 'required']);
        $task->update($request->all());
        return redirect()->back();
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->back();
    }

    public function reorder(Request $request)
    {
        $data = $request->all();

        foreach ($data['order'] as $index => $taskId) {
            Task::where('id', $taskId)->update(['priority' => $index + 1]);
        }

        return response()->json(['status' => 'success']);
    }
}


