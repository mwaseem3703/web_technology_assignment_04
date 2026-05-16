<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * HOME PAGE: Display task list for management.
     */
    public function index()
    {
        $tasks = Auth::user()->tasks()->latest()->paginate(10);
        return view('tasks.index', compact('tasks'));
    }

    /**
     * ANALYTICS DASHBOARD: Display charts and visualizations.
     */
    public function dashboard()
    {
        $user = Auth::user();
        
        $stats = [
            'total' => $user->tasks()->count(),
            'pending' => $user->tasks()->where('status', 'Pending')->count(),
            'completed' => $user->tasks()->where('status', 'Completed')->count(),
        ];

        return view('dashboard', compact('stats'));
    }

    /**
     * STORE: Save a newly created task to the database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date'  => 'nullable|date',
            'due_date'    => 'required|date',
            'priority'    => 'required|in:Low,Medium,High',
            'status'      => 'required|in:Pending,Completed',
        ]);

        Auth::user()->tasks()->create($validated);

        return redirect()->route('tasks.index')->with('success', 'Task created successfully!');
    }

    /**
     * UPDATE: Save the modifications made to a task.
     */
    public function update(Request $request, Task $task)
    {
        // Security check: Ensure the user actually owns the task before updating
        if ($task->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date'  => 'nullable|date',
            'due_date'    => 'required|date',
            'priority'    => 'required|in:Low,Medium,High',
            'status'      => 'required|in:Pending,Completed',
        ]);

        $task->update($validated);

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully!');
    }

    /**
     * DESTROY: Delete a task from the database.
     */
    public function destroy(Task $task)
    {
        // Security check: Ensure the user actually owns the task before deleting
        if ($task->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully!');
    }
}