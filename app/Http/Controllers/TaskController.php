<?php

namespace App\Http\Controllers;

use App\Http\Requests\Tasks\Create;
use App\Models\Task;
use App\Models\TaskParticipants;
use Auth;
use Exception;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Redirect;

class TaskController extends Controller
{
    /**
     *  Returns a list of all the shopping list items
     */
    public function index()
    {
        $tasks = Task::with('participants')
            ->get();

        $out = [];
        foreach ($tasks as $task) {
            $out[$task->id] = $task;
        }

        return Inertia::render('Tasks/Index', [
            'searchable_tasks' => $out,
            'tasks' => $tasks,
            'user_id' => Auth::id()
        ]);
    }

    /**
     * Create a new shopping list item
     *
     * @param Create $request
     * @return RedirectResponse
     */
    public function create(Create $request) : RedirectResponse
    {
        $task = Task::make($request->validated());
        $task->end = $request->input('full_day') === true ? null : $task->end;
        $task->user_id = Auth::id();
        $task->save();

        return Redirect::route('tasks');
    }

    public function update(Create $request, int $id) : RedirectResponse
    {
        $task = Task::find($id);
        if($task === false) {
            return Redirect::route('tasks')->with('error', 'Task can\'t be found.');
        }

        if ($task->user_id !== Auth::id()) {
            return Redirect::route('tasks')->with('error', 'You can only edit tasks that you have created.');
        }

        $task->update($request->validated());
        $task->end = $request->input('full_day') === true ? null : $task->end;
        $task->save();
        return Redirect::route('tasks');
    }

    /**
     * @param int $task
     * @return RedirectResponse
     */
    public function delete(int $task) : RedirectResponse
    {
        try {
            $task = Task::find($task);
            if ($task === null) {
                return Redirect::route('tasks')->with('error', 'Task can\'t be found.');
            }
            $task->delete();
        } catch (Exception $e) {
            return Redirect::route('tasks')->with('error', $e->getMessage());
        }

        return Redirect::route('tasks');
    }

    /**
     * @param int $task
     * @return RedirectResponse
     */
    public function join(int $task) : RedirectResponse
    {
        $participating = TaskParticipants::whereTaskId($task)
            ->where('user_id', Auth::id())
            ->first();

        if ($participating === null) {
            // Create the record
            TaskParticipants::create([
                'user_id' => Auth::id(),
                'task_id' => $task
            ]);
        }else {
            // Delete the record
            try {
                $participating->delete();
            } catch (Exception $e) {
                return Redirect::route('tasks')->with('error', $e->getMessage());
            }
        }

        return Redirect::route('tasks');
    }
}
