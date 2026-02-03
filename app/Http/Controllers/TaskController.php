<?php
namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        return Task::where('project_id', $request->project_id)
            ->orderBy('priority')
            ->get();
    }

    public function store(Request $request)
    {
        $max = Task::where('project_id', $request->project_id)->max('priority') ?? 0;

        Task::create([
            'name'       => $request->name,
            'project_id' => $request->project_id,
            'priority'   => $max + 1,
        ]);

        return redirect()->back();
    }

    public function update(Request $request, Task $task)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $task->update([
            'name' => $request->name,
        ]);

        return response()->json(['success' => true]);
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return response()->json();
    }

    public function reorder(Request $request)
    {
        foreach ($request->order as $i => $id) {
            Task::where('id', $id)->update(['priority' => $i + 1]);
        }
        return response()->json();
    }
}
