<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Redirect;

class TaskController extends Controller
{
    /**
     *  Returns a list of all the shopping list items
     */
    public function index()
    {
        return Inertia::render('Tasks/Index', [
            'tasks' => Task::all()
        ]);
    }

    /**
     * Create a new shopping list item
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function create(Request $request) : RedirectResponse
    {


        return Redirect::route('tasks');
    }

    public function update(Request $request) : RedirectResponse
    {

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
            $task->delete();
        } catch (Exception $e) {
            // Share a flash message
            Inertia::share('flash', function () use ($e) {
                return [
                    'message' => $e->getMessage()
                ];
            });
        }

        return Redirect::route('tasks');
    }
}
